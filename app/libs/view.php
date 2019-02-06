<?php

class View {

    protected $result;

    /**
     * View constructor.
     * @param $template_path string
     * @param $_DATA array
     */
    protected function __construct($template_path, $_DATA) {
        ob_start();
        include $template_path;
        $this->result = ob_get_clean();
    }

    /**
     * @param $template string
     * @param $_DATA array
     * @return View
     */
    static function render($template, $_DATA = []) {
        $template_path = HOME_PATH.'/pages/views/'.$template.".php";
        return is_readable($template_path) ? new View($template_path, $_DATA) : null;
    }

    /**
     * @return string
     */
    function __toString() {
        return ltrim($this->result);
    }

    /**
     * display
     */
    function display() {
        echo ltrim($this->result);
    }

    /**
     * The prohibition of creating duplicates
     */
    private function __clone()  {}
    private function __wakeup() {}

}