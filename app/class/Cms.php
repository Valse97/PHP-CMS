<?php
require_once("core/Dates.php");
require_once("core/Utils.php");
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 24/06/2017
 * Time: 14:47
 */
class Cms {

    /* GET */
    public static function getAllAttributes(){
        $db = Db::instance();
        $list = $db->raw('select * from _cms_attributes')->all();
        return $list;
    }
    public static function getAttributesById($id){
        $db = Db::instance();
        $list = $db->raw('select * from _cms_attributes where id='.$id)->fetch();
        return $list;
    }
    public static function getAllComponents(){
        $db = Db::instance();
        $list = $db->raw('select * from _cms_components order by sort')->all();
        return $list;
    }
    public static function getAllComponentAttributesByComponentId($componentId){
        $db = Db::instance();
        $list = $db->raw('select * from _cms_component_attributes where _cms_component_id = '.$componentId.' order by id')->all();
        return $list;
    }
    public static function getComponentById($id){
        $db = Db::instance();
        $list = $db->select('_cms_components','*', array('id' => $id))->fetch();
        return $list;
    }
    public static function getComponentBySingularName($singular_name){
        $db = Db::instance();
        $list = $db->select('_cms_components','*', array('singular_name' => $singular_name))->fetch();
        return $list;
    }
    public static function getComponentByPluralName($plural_name){
        $db = Db::instance();
        $list = $db->select('_cms_components','*', array('plural_name' => $plural_name))->fetch();
        return $list;
    }

    public static function getComponentAttributeById($id){
        $db = Db::instance();
        $list = $db->select('_cms_component_attributes','*', array('id' => $id))->fetch();
        return $list;
    }
    public static function getComponentAttributeByComponentIdAndValueName($componentId, $value_name){
        $db = Db::instance();
        $list = $db->select('_cms_component_attributes','*', array('_cms_component_id' => $componentId , 'value_name' => $value_name))->fetch();
        return $list;
    }


    /* CREATE */
    public static function createComponent($data){
        $obj = json_decode($data);
        $singular_name = $obj->singular_name;
        $plural_name = $obj->plural_name;
        $db = Db::instance();
        $return = new StdClass();

        $return->success = true;
        $return->msg = "Errore imprevisto";

        if(empty($singular_name) || empty($plural_name)){
            $return->success = false;
            $return->msg = "Inserire tutti i campi";
        }else if(empty(self::getComponentBySingularName($singular_name)) && empty(self::getComponentByPluralName($plural_name))) {

            $db->raw("CREATE TABLE cms_" . $plural_name . " (
            id int(11) NOT NULL,
            _cms_component_id int(11) NOT NULL
            )");

            $db->raw("CREATE TABLE cms_" . $singular_name . "_attributes (
                id int(11) NOT NULL,
                cms_" . $singular_name . "_id int(11) NOT NULL,
                _cms_component_attribute_id int(11) NOT NULL,
                value varchar(200) NOT NULL
            )");

            $components = self::getAllComponents();
            if(empty($components)){
                $db->create('_cms_components', array('singular_name' => $singular_name, 'plural_name' => $plural_name, 'sort' => 1));
            }else{
                $sort = intval(end($components)->sort) +1;
                $db->create('_cms_components', array('singular_name' => $singular_name, 'plural_name' => $plural_name, 'sort' => $sort));
            }

            $return->success = true;
            $return->msg = "Il componente '".$singular_name."' è stato creato con successo";

            $compId = $db->id();
            $comp = self::getComponentById($compId);
            $return->object = $comp;
        }else{
            $return->success = false;
            $return->msg = "I nomi usati esistono già";
        }

        return $return;
    }

    public static function createComponentAttribute($data){
        $obj = json_decode($data);
        $componentId = $obj->componentId;
        $attributeId = $obj->_cms_attribute_id;
        $value_name = $obj->value_name;
        $required = $obj->required;
        $placeholder = $obj->placeholder;
        $default_value = $obj->default_value;
        $size = $obj->size;
        $max_length = $obj->max_length;

        $db = Db::instance();
        $return = new StdClass();

        $return->success = true;
        $return->msg = "Errore imprevisto";

        /* trovo il componente */
        $componentName = self::getComponentById($componentId)->singular_name;

        if(empty(self::getComponentAttributeByComponentIdAndValueName($componentId,$value_name))) {
            $db->create('_cms_component_attributes', array(
                '_cms_component_id' => $componentId,
                '_cms_attribute_id' => $attributeId,
                'value_name' => $value_name,
                'required' => $required,
                'placeholder' => $placeholder,
                'default_value' => $default_value,
                'size' => $size,
                'max_length' => $max_length));


            $return->success = true;
            $return->msg = "L'attibuto '".$value_name."' del componente '"+$componentName+"' è stato creato con successo";

            $compAttrId = $db->id();
            $compAttr = self::getComponentAttributeById($compAttrId);
            $return->object = $compAttr;
        }else{
            $return->success = true;
            $return->msg = "Errore imprevisto";
        }

        return $return;
    }


    /* EDIT */
    public static function editComponent($data){
        $obj = json_decode($data);
        $id = $obj->id;
        $singular_name = $obj->singular_name;
        $plural_name = $obj->plural_name;
        $db = Db::instance();
        $return = new StdClass();

        $return->success = true;
        $return->msg = "Errore imprevisto";

        if(empty($singular_name) || empty($plural_name)){
            $return->success = false;
            $return->msg = "Inserire tutti i campi";
        }else {
            $comp = self::getComponentById($id);
            if ($comp->singular_name != $singular_name && !empty(self::getComponentBySingularName($singular_name))) {
                $return->success = false;
                $return->msg = "I nomi usati esistono già";
            }else if ($comp->plural_name != $plural_name && !empty(self::getComponentByPluralName($plural_name))){
                $return->success = false;
                $return->msg = "I nomi usati esistono già";
            }else{
                $components = self::getAllComponents();

                unset($obj->id);

                $db->update('_cms_components', get_object_vars($obj), $id);

                $return->success = true;
                $return->msg = "Il componente '" . $singular_name . "' è stato modificato con successo";

                $compId = $id;
                $comp = self::getComponentById($compId);
                $return->object = $comp;
            }
        }

        return $return;
    }

    public static function editComponentAttribute($componentId, $attributeId, $value_name, $required = false,$placeholder = "",$default_value = "",$size = null,$max_length = null){
        $db = Db::instance();
        $return = new StdClass();

        $return->success = true;
        $return->msg = "Errore imprevisto";

        /* trovo il componente */
        $component = self::getComponentById($componentId)->singular_name;

        if(empty(self::getComponentAttributeByComponentIdAndValueName($componentId,$value_name))) {
            $db->create('cms_component_attributes', array(
                '_cms_component_id' => $componentId,
                '_cms_attribute_id' => $attributeId,
                'value_name' => $value_name,
                'required' => $required,
                'placeholder' => $placeholder,
                'default_value' => $default_value,
                'size' => $size,
                'max_length' => $max_length));


            $return->success = true;
            $return->msg = "L'attibuto '".$value_name."' del componente '"+$component->singular_name+"' è stato creato con successo";

            $compAttrId = $db->id();
            $compAttr = self::getComponentAttributeById($compAttrId);
            $return->object = $compAttr;
        }else{
            $return->success = true;
            $return->msg = "Errore imprevisto";
        }

        return $return;
    }


    /* DELETE */
    public static function deleteComponent($id){
        $db = Db::instance();
        $return = new StdClass();

        $return->success = true;
        $return->msg = "Errore imprevisto";


        $component = self::getComponentById($id);

        if(empty($component)){
            $return->success = false;
            $return->msg = "Componente non trovato";
        }else {
            if(count($db->raw("SHOW TABLES LIKE 'cms_" . $component->singular_name . "_attributes'")->all()) > 0) {
                $db->raw("DROP TABLE cms_" . $component->singular_name . "_attributes");
            }
            if(count($db->raw("SHOW TABLES LIKE '
            cms_" . $component->plural_name."'")->all()) > 0) {
                $db->raw("DROP TABLE cms_" . $component->plural_name);
            }

            $db->delete('_cms_components', $id);

            $return->success = true;
            $return->msg = "Il componente '".$component->singular_name."' è stato eliminato con successo";
        }

        return $return;
    }
}