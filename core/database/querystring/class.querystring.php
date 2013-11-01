<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:34
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;


class QueryString {

    /**
     * Formate une clef
     * <code><br>
     * $key = Query::toKey("key");<br>
     * echo $key;<br>
     * //Retourne<br>
     * // `key`<br>
     * </code>
     * @param String $var la clef à formatée
     * @return String Chaine formatée
     */
    public static function toKey($var) {
        return '`' . trim($var, '`') . '`';
    }

    /**
     * Formate une valeur.
     * @param String $value
     * @return String valeur formatée
     */
    public static function toValue($value) {
        // @todo test si entier ou string
        return "'" . $value . "'";
    }

    /**
     * Formate les couples attributPublic = valeur
     * `attributPublic` = 'valeur'
     * @param type $publicAttributs
     * @return boolean|string
     */
    public static function toUpdate($associativeArray) {
        $buffer = "";
        $i = 0;
        $loops = count((array)$associativeArray);
        foreach ($associativeArray as $key => $value) {
            $i++;
            //$buffer .= ' ' . QueryString::toKey($key) . '=\'?\'';
            $buffer .= ' ' . $key . '=? ';
            $buffer .= ($i!==$loops) ? ", " : '';
        }
        return $buffer;
    }

    /**
     * Formate un tableau en chaine SQL valide pour les requêtes de type UPDATE
     */
    /*
    public static function toInsert($publicAttributs, $wich = 'both', $tableName = null) {

            $publicAttributs = (array)$publicAttributs;
            $list = array();
            $colsName = array_keys($publicAttributs);
            $colsName = array_map('LibreMVC\\Database\\QueryString::toKey', $colsName);
            $list['keys'] = ' ( ' . implode(', ', $colsName) .' ) ';
            $list['values'] = ' ( ' . implode(', ', array_values($publicAttributs)) . ' ) ';

            switch ($wich) {
                default:
                case 'both':
                    return $list;
                    break;

                case 'keys':
                    return $list['keys'];
                    break;

                case 'values':
                    return $list['values'];
                    break;
            }
    }
    */

    public static function toInsert( &$item ) {
        $item = self::toKey($item);
    }

}