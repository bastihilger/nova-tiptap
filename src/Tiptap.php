<?php

namespace Manogi\Tiptap;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Expandable;

class Tiptap extends Field
{
    use Expandable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'tiptap';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Set the buttons that should be available in the menu.
     *
     * @param  array  $buttons
     * @return $this
     */
    public function buttons(array $buttons)
    {
        return $this->withMeta([
            'buttons' => $buttons
        ]);
    }

    /**
     * Set the heading levels that should be available when using headings
     *
     * @param  mixed  $headingLevels
     * @return $this
     */
    public function headingLevels($headingLevels)
    {
        $headingLevelsArr = $headingLevels;
        if (is_int($headingLevels)) {
            $headingLevelsArr = [];
            for ($n = 1; $n <= $headingLevels; $n++) {
                $headingLevelsArr[] = $n;
            }
        }

        return $this->withMeta([
            'headingLevels' => $headingLevelsArr
        ]);
    }

    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'shouldShow' => $this->shouldBeExpanded(),
        ]);
    }
}
