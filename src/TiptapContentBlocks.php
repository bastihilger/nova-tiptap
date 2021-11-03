<?php

namespace Manogi\Tiptap;

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

        $content = preg_replace_callback(
            '/<gallery-content-block slides="(.*?)" slidecount="(.*?)" mode="(.*?)" key="(.*?)" imagedisk="(.*?)" imagepath="(.*?)"><\/gallery-content-block>/is',
            function ($matches) {
                $slides = json_decode(html_entity_decode($matches[1]));
                $slideCount = intval($matches[2]);
                $mode = $matches[3];

                $html = '<div class="ttcp-'.$mode.'-wrapper"><div class="ttcp-'.$mode.'-inner"><div class="ttcp-'.$mode.'-stage">';

                foreach ($slides as $slide) {
                    $html .= '<div class="ttcp-'.$mode.'-slide">';
                    $html .= '<div class="ttcp-'.$mode.'-image-wrapper">';
                    $html .= '<img class="ttcp-'.$mode.'-image" src="'.$slide->src.'" />';
                    $html .= '</div>';
                    $html .= '<div class="ttcp-'.$mode.'-subtext">';
                    $html .= '<div class="ttcp-'.$mode.'-caption">'.$slide->caption.'</div>';
                    $html .= '<div class="ttcp-'.$mode.'-credits">'.$slide->caption.'</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                }

                $html .= '</div></div></div>';

                return $html;
            },
            $content
          );

        return $content;
    }
}
