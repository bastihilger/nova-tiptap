<?php

namespace Manogi\Tiptap;

use Illuminate\Support\Str;

class TiptapContentBlocks
{
    public function parse($content)
    {
        $content = preg_replace_callback(
            '/<video-content-block embedcode="(.*?)" caption="(.*?)" credits="(.*?)" ratio="(.*?)" key="(.*?)"><\/video-content-block>/is',
            function ($matches) {
                return '<div class="ttcp-video-wrapper" ratio="'.$matches[4].'">
                    <div class="ttcp-video-inner">
                        <div class="ttcp-iframe-wrapper">'
                        .html_entity_decode($matches[1])
                        .'</div>
                        <div class="ttcp-below-video">
                            <div class="ttcp-caption">'.($matches[2] ?: '').'</div>
                            <div class="ttcp-credits">'.($matches[3] ?: '').'</div>
                        </div>
                    </div>
                </div>';
            },
            $content
          );

        return $content;
    }
}
