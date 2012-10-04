<?php

namespace pff;

/**
 * Layout system with PHP templates
 *
 * A layout is a specific type of View: it represents a common layout with most
 * of its elements fixed and a few placeholders to render custom views.
 *
 * @author paolo.fagni<at>gmail.com
 */
class LayoutPHP extends \pff\ViewPHP
{

    /**
     * @var \pff\AView[]
     */
    private $_contentView;

    /**
     * Adds an Aview to the layout queue
     *
     * @param \pff\AView $view
     */
    public function addContent(\pff\AView $view)
    {
        $this->_contentView[] = $view;
    }

    /**
     * Show the content in the layout
     *
     * Add "<?php $this->content()?>" in your layout template where you want to
     * display the AView object
     *
     * @param int $index
     */
    public function content($index = 0)
    {
        $this->_contentView[$index]->render();
    }
}
