<?php

class View
{

    protected $variables;
    protected $output;

    public function render($file, $variables = null)
    {
        $this->variables = $variables;
        $file = PATH_VIEWS . $file;

        ob_start();
        $this->includeFile($file);
        $this->output = ob_get_contents();
        ob_end_clean();

        return $this->output;
    }

    private function includeFile($file)
    {
        if (isset($this->variables) && is_array($this->variables)) {
            foreach ($this->variables as $key => $value) {
                global ${$key};
                ${$key} = $value;
            }
        }

        if (file_exists($file)) {
            // hay que retornar ya que si no queda en el ambito de la funcion
            return include $file;
        } else if (file_exists($file . '.php')) {
            return include $file . '.php';
        } else if (file_exists($file . '.html')) {
            return include $file . '.html';
        } else {
            echo "<h2>No existe el archivo $file </h2>";
        }
    }
}