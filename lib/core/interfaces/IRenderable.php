<?php

namespace pff;


interface IRenderable {

    /**
     * Sets a value to be passed to a View
     *
     * @return mixed
     */
    public function set($name, $value);

    /**
     * Renderes the view
     *
     * @return mixed
     */
    public function render();

    /**
     * Returns the rendered HTML without output to browser
     *
     * @return mixed
     */
    public function renderHtml();

}