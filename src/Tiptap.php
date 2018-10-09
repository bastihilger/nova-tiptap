<?php

namespace Manogi\Tiptap;

use Laravel\Nova\Fields\Field;

class Tiptap extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'tiptap';

    /**
     * Set the buttons that should be available in the menu.
     *
     * @param  array  $buttons
     * @return $this
     */
    public function buttons(array $buttons)
    {
        return $this->withMeta(['buttons' => $buttons]);
    }
}
