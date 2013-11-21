<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marco
 * Date: 07/12/12
 * Time: 16.04
 * To change this template use File | Settings | File Templates.
 */
namespace pff\modules;

/**
 * Helper module to search into a database
 *
 * @author marco.sangiorgi<at>neropaco.net
 */


class Searcher extends \pff\AModule
{

    private $models_array;

    public function __construct(array $models)
    {
        $this->models_array = $models;
    }

    /**
     * @param $what //what you want to search
     * @param $type //search type, possible values are text
     * @param $_em //the entity manager, needed to search on db
     * @param array $excludeArray //an array formed like $excludeArray['modelname']['field1, field2, ...]
     * @return array //returns an array formed like $return['modelname']['entity1', 'entity2'], ...]
     * in case of daterange search, what must be an array formatted like [dateFrom, dateTo, fieldSeparator] (i.e.: ["03-03-2013", "07-03-2013", "-"])
     */
    public function search($what, $type, $_em, array $excludeArray = array()){
        if($what == ""){
            return false;
        }
        $return = array();
        foreach($this->models_array as $model){
            switch($type){
                case "text":
                    if(isset($excludeArray[$model])){
                        $return[$model] = $this->searchText($what, $model, $_em, $excludeArray[$model]);
                    }else{
                        $return[$model] = $this->searchText($what, $model, $_em);
                    }
                    break;
                case "number":
                    if(isset($excludeArray[$model])){
                        $return[$model] = $this->searchNumber($what, $model, $_em, $excludeArray[$model]);
                    }else{
                        $return[$model] = $this->searchNumber($what, $model, $_em);
                    }
                    break;
                case "numberExact":
                    if(isset($excludeArray[$model])){
                        $return[$model] = $this->searchNumberExact($what, $model, $_em, $excludeArray[$model]);
                    }else{
                        $return[$model] = $this->searchNumberExact($what, $model, $_em);
                    }
                    break;
                case "textExact":
                    if(isset($excludeArray[$model])){
                        $return[$model] = $this->searchTextExact($what, $model, $_em, $excludeArray[$model]);
                    }else{
                        $return[$model] = $this->searchTextExact($what, $model, $_em);
                    }
                    break;
                case "dateRange":
                    if(isset($excludeArray[$model])){
                        $return[$model] = $this->searchDateRange($what, $model, $_em, $excludeArray[$model]);
                    }else{
                        $return[$model] = $this->searchDateRange($what, $model, $_em);
                    }
                    break;
            }
        }
        return $return;
    }

    /**
     * @param $what
     * @param $modelname
     * @param $_em
     * @param array $excludeArray
     * @return bool, array
     * return an array of entity matching $what, false otherwise
     */
    private function searchText($what, $modelname, $_em, $excludeArray = array()){
        $reflector = new \ReflectionClass("\pff\models\\".$modelname);
        $properties = $this->my_class_type($reflector);
        $searchableProperties = array();
        foreach($properties as $key=>$value){
            if(($value == "string" || $value == "text") &&  !in_array($key, $excludeArray)){
                array_push($searchableProperties, $key);
            }
        }
        if(count($searchableProperties) == 0){
            return false;
        }
        $qb = $_em->createQueryBuilder();
        $qb->select('f')
            ->from("pff\models\\".$modelname, 'f');
        $or = $qb->expr()->orx();
        foreach($searchableProperties as $prop){
            $or->add($qb->expr()->like("f.{$prop}", ":{$key}" ));
            $qb->setParameter($key, "%{$what}%");
        }
        $qb->where($or);
        $results = $qb->getQuery()->getResult();
        if(count($results) == 0){
            return false;
        }
        return $results;
    }

    /**
     * @param $what
     * @param $modelname
     * @param $_em
     * @param array $excludeArray
     * @return bool, array
     * return an array of entity matching $what, false otherwise
     */
    private function searchNumber($what, $modelname, $_em, $excludeArray = array()){
        $reflector = new \ReflectionClass("\pff\models\\".$modelname);
        $properties = $this->my_class_type($reflector);
        $searchableProperties = array();
        foreach($properties as $key=>$value){
            if((($value == "integer") || ($value == "float")) &&  !in_array($key, $excludeArray)){
                array_push($searchableProperties, $key);
            }
        }
        if(count($searchableProperties) == 0){
            return false;
        }
        $qb = $_em->createQueryBuilder();
        $qb->select('f')
            ->from("pff\models\\".$modelname, 'f');
        $or = $qb->expr()->orx();
        foreach($searchableProperties as $prop){
            $or->add($qb->expr()->like("f.{$prop}", ":{$key}" ));
            $qb->setParameter($key, "%{$what}%");
        }
        $qb->where($or);
        $results = $qb->getQuery()->getResult();
        if(count($results) == 0){
            return false;
        }
        return $results;
    }

    /**
     * @param $what
     * @param $modelname
     * @param $_em
     * @param array $excludeArray
     * @return bool, array
     * return an array of entity matching $what, false otherwise
     */
    private function searchNumberExact($what, $modelname, $_em, $excludeArray = array()){
        $reflector = new \ReflectionClass("\pff\models\\".$modelname);
        $properties = $this->my_class_type($reflector);
        $searchableProperties = array();
        foreach($properties as $key=>$value){
            if((($value == "integer") || ($value == "float")) &&  !in_array($key, $excludeArray)){
                array_push($searchableProperties, $key);
            }
        }
        if(count($searchableProperties) == 0){
            return false;
        }
        $qb = $_em->createQueryBuilder();
        $qb->select('f')
            ->from("pff\models\\".$modelname, 'f');
        $or = $qb->expr()->orx();
        foreach($searchableProperties as $prop){
            $or->add($qb->expr()->like("f.{$prop}", ":{$key}" ));
            $qb->setParameter($key, "{$what}");
        }
        $qb->where($or);
        $results = $qb->getQuery()->getResult();
        if(count($results) == 0){
            return false;
        }
        return $results;
    }

    /**
     * @param $what
     * @param $modelname
     * @param $_em
     * @param array $excludeArray
     * @return bool, array
     * return an array of entity matching $what, false otherwise
     */
    private function searchTextExact($what, $modelname, $_em, $excludeArray = array()){
        $reflector = new \ReflectionClass("\pff\models\\".$modelname);
        $properties = $this->my_class_type($reflector);
        $searchableProperties = array();
        foreach($properties as $key=>$value){
            if(($value == "string" || $value == "text") &&  !in_array($key, $excludeArray)){
                array_push($searchableProperties, $key);
            }
        }
        if(count($searchableProperties) == 0){
            return false;
        }
        $qb = $_em->createQueryBuilder();
        $qb->select('f')
            ->from("pff\models\\".$modelname, 'f');
        $or = $qb->expr()->orx();
        foreach($searchableProperties as $prop){
            $or->add($qb->expr()->like("f.{$prop}", ":{$key}" ));
            $qb->setParameter($key, "{$what}");
        }
        $qb->where($or);
        $results = $qb->getQuery()->getResult();
        if(count($results) == 0){
            return false;
        }
        return $results;
    }

    /**
     * @param $what
     * @param $modelname
     * @param $_em
     * @param array $excludeArray
     * @return bool, array
     * return an array of entity matching $what, false otherwise
     */
    private function searchDateRange($what, $modelname, $_em, $excludeArray = array()){
        if(!is_array($what) && count($what) != 3){
            return false;
        }
        $reflector = new \ReflectionClass("\pff\models\\".$modelname);
        $properties = $this->my_class_type($reflector);
        $searchableProperties = array();
        foreach($properties as $key=>$value){
            if(($value == "datetime" || $value == "date") &&  !in_array($key, $excludeArray)){
                array_push($searchableProperties, $key);
            }
        }
        if(count($searchableProperties) == 0){
            return false;
        }
        $data_da = str_replace($what[2],"-",$what[0]);
        $data_a = str_replace($what[2],"-",$what[1]);
        $data_da = date("Y-m-d",strtotime($data_da));
        $data_a = date("Y-m-d",strtotime($data_a));

        $qb = $_em->createQueryBuilder();
        $qb->select('f')
            ->from("pff\models\\".$modelname, 'f');
        $or = $qb->expr()->orx();
        foreach($searchableProperties as $prop){
            $or->add($qb->expr()->between("f.{$prop}", ":da", ":a" ));
            $qb->setParameter("da", "{$data_da}");
            $qb->setParameter("a", "{$data_a}");
        }
        $qb->where($or);
        $results = $qb->getQuery()->getResult();
        if(count($results) == 0){
            return false;
        }
        return $results;
    }

    /**
     * @param $reflector
     * @return array
     * returns an array property_name => property_type
     */
    private function my_class_type($reflector)
    {
        $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();

        $typeArray = array();
        $tmpArray = array();
        foreach($reflector->getProperties() as $property){
            $tmpArray[$property->name] = $annotationReader->getPropertyAnnotations($property);
        }
        foreach($tmpArray as $prop=>$p){
            foreach($p as $r){
                if(is_a($r, 'Doctrine\ORM\Mapping\Column')){
                    $typeArray[$prop] = $r->type;
                }
            }
        }
        return $typeArray;
    }



}
