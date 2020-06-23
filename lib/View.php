<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 19:02
 */

namespace lib;


class View
{
/*
    static public function make($view_name, $param = []){
        extract($param);
        $view_path = ROOT_PATH.'/app/Views/'.$view_name.'.php';
        ob_start();
        require_once $view_path;
        return ob_get_clean();
    }
*/
    private static $variables = [];
    private static $viewData = '';

    static public function make($view_name, $params = []){
        self::$variables = $params;
        extract($params);
        $rend_path = self::analyticTemplate($view_name);
        ob_start();
        require_once $rend_path;
        return ob_get_clean();
    }


    static private function  analyticTemplate($view_name){
        $view_path = ROOT_PATH.'/app/Views/'.$view_name.'.blade.php';
        $cache_path = ROOT_PATH.'/cache/views/'. md5($view_name);

        if(file_exists($view_path) == false)
            throw new \Exception('file:'. $view_path.' not exists');

        $view_time = filectime($view_path);
        $cache_time = 0;
        if(file_exists($cache_path) == true){
            $cache_time = filectime($cache_path);
        }

        //if($cache_time && $view_time < $cache_time){
        //    return $cache_path;
        //}

        self::$viewData = file_get_contents($view_path);


        $repl = [
            '/(@) *(include)\((.*)\)\W/U',   // << @func($args...);
        ];
        self::$viewData = preg_replace_callback($repl, 'static::replace', self::$viewData);


        $repl = [
            '/{{ ?(\$)(\w.+) ?}}/U',        // << $a;
            '/{{ ?(~\$)(\w.+) ?}}/U',       // << ~$a;
            '/(@) ?(\w+)\((.*)\);/U',      // << @func($args...);
            '/(@) ?(.*::\w+)\((.*)\);/U',      // << @func($args...);
            '/(@) ?(\w+);/U',              // << @func($args...);
        ];
        self::$viewData = preg_replace_callback($repl, 'static::replace', self::$viewData);

        file_put_contents($cache_path, self::$viewData);
        return $cache_path;
    }

    /*
    static function render($pattern){
        self::$viewData = preg_replace_callback($pattern, 'static::replace', self::$viewData);
    }

    static function extendsTemplate(){
        self::$viewData = preg_replace_callback('/@ *extends\((.*)\) ?;/U', function ($matches){

        }, self::$viewData);
    }
    */

    static function replace($matches){
        switch ($matches[1]){
            case "$":
                return '<?php echo $'.$matches[2].'?>';
            case "~$":
                return  '<?php echo isset($'.$matches[2].') ? $'.$matches[2].' : "" ?>';
            case "@":
                switch ($matches[2]){
                    case "include":
                        return file_get_contents(VIEW_PATH. '/' . trim($matches[3], '/\'').'.blade.php');
                    case 'for':
                        return '<?php for('.$matches[3].'): ?>';
                    case 'endfor':
                        return '<?php endfor;?>';
                    case 'foreach':
                        return '<?php foreach('.$matches[3].'): ?>';
                    case 'endforeach':
                        return '<?php endforeach;?>';
                    case 'if':
                        return '<?php if('.$matches[3].'): ?>';
                    case 'endif':
                        return '<?php endif;?>';
                    default:
                      return '<?php echo '.$matches[2].'('.$matches[3].') ?>';
                }

            default:
                return $matches[0];

        }

    }



/*  // 老函数
    static private function  analyticTemplate($view_name){
        $view_path = ROOT_PATH.'/app/Views/'.$view_name.'.blade.php';
        $cache_path = ROOT_PATH.'/cache/views/'. md5($view_name);

        $view_time = filectime($view_path);
        $cache_time = 0;
        if(file_exists($cache_path) == true){
            $cache_time = filectime($cache_path);
        }

        if($cache_time && $view_time < $cache_time){
            return $cache_path;
        }


        $data = file_get_contents($view_path);

        $repl = [
            '/\{\{ ?(\$\w.+) ?\}\}/U',       // << $a;
            '/\{\{ ?~(\$\w.+) ?\}\}/U',      // << ~$a;
            '/\@ ?(\w+\(.*\)) ?;/U',   // << @func($args...);
        ];

        $contents = [
            '<?php echo $1 ?>',
            '<?php echo empty($1) ? "" : $1 ?>',
            '<?php echo $1 ?>',
        ];

        $cache = preg_replace($repl, $contents, $data);
        file_put_contents($cache_path, $cache);
        return $cache_path;
    }
*/

}