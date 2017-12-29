<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/20/2017
 * Time: 10:45 AM
 */

namespace  App\Model\HtmlGateway;


class HeaderHtmlGateway_old
{
    private $template=null;
    private $helpers=[];

    private $gateways=[];

    public function __construct($template = null, $helpers = [])
    {
        $this->template = $template;
        $this->helpers  = $helpers;
    }

    public function __call($name, $arguments)
    {
        throw new \Exception($name." not found");
    }

    public function render($title){
        try {
            $level = ob_get_level();
            ob_start();

            include 'src/App/templates/layout/default.phtml';

            $content = ob_get_clean();

            return $content;
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }

    public function content()
    {
        $html='';
        foreach($this->gateways as $gateway) {
            $html .= $gateway->render();
        }
        return $html;
    }

    public function addHtmlGateway($gateway){
        $this->gateways[]=$gateway;
        return $this;
    }

    /**
     * Escape string.
     * @param  string      $string
     * @return string
     */
    public function escape($string)
    {
        static $flags;

        if (!isset($flags)) {
            $flags = ENT_QUOTES | (defined('ENT_SUBSTITUTE') ? ENT_SUBSTITUTE : 0);
        }

        return htmlspecialchars($string, $flags, 'UTF-8');
    }

    public function e($string)
    {
        return $this->escape($string);
    }

    public function section($t)
    {

    }

    public function translate($string)
    {
        return $this->escape($string);
    }

}