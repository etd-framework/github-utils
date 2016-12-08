<?php

use Opnmind\SVG\Nodes\Shapes\SVGPath;
use Opnmind\SVG\Nodes\Shapes\SVGText;
use Opnmind\SVG\SVGImage;
use Opnmind\SVG\Nodes\Shapes\SVGRect;

class LabelGenerator {

    protected $text;
    protected $bg;
    protected $color;

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function setBg($bg) {
        $this->bg = $bg;
        return $this;
    }

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    /**
     * @return SVGImage
     */
    public function getImage() {

        $w = 42;
        $h = 33;
        $x = 0.5;
        $y = 0.5;
        $r = 3;

        $w += strlen($this->text) * 9;

        $image = new SVGImage($w+1, $h+1);
        $doc   = $image->getDocument();

        $stroke_color = "none";
        if ($this->bg == "fff" || $this->bg == "ffffff") {
            $stroke_color = "#eee";
        }

        $square = new SVGRect($x, $y, $r, $r, $w, $h);
        $square->setStyle('fill', '#' . $this->bg);
        $square->setStyle('stroke', $stroke_color);
        $square->setStyle('stroke-width', '1px');
        $doc->addChild($square);

        $shadow = new SVGRect($x, $y, $r, $r, $w, $h-1);
        $shadow->setStyle('fill', 'none');
        $shadow->setStyle('stroke', '#0000001a');
        $shadow->setStyle('stroke-dasharray', '0,'.($w + $h-1 - $r*2).','.($w).','.($h-1));
        $doc->addChild($shadow);

        $text = new SVGText($x + 31, $y + 16+7, $this->text, "16px", $this->color, "-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'");
        $text->setStyle("font-weight", "bold");
        $doc->addChild($text);

        $icon = new SVGPath("M7.73 1.73C7.26 1.26 6.62 1 5.96 1H3.5C2.13 1 1 2.13 1 3.5v2.47c0 .66.27 1.3.73 1.77l6.06 6.06c.39.39 1.02.39 1.41 0l4.59-4.59a.996.996 0 0 0 0-1.41L7.73 1.73zM2.38 7.09c-.31-.3-.47-.7-.47-1.13V3.5c0-.88.72-1.59 1.59-1.59h2.47c.42 0 .83.16 1.13.47l6.14 6.13-4.73 4.73-6.13-6.15zM3.01 3h2v2H3V3h.01z");
        $icon->setAttribute("transform", "translate(" . ($x + 10+0.5) . "," . ($y + 10+0.5) . ")");
        $icon->setStyle("fill", $this->color);
        $doc->addChild($icon);

        //<path fill-rule="evenodd" d="M7.73 1.73C7.26 1.26 6.62 1 5.96 1H3.5C2.13 1 1 2.13 1 3.5v2.47c0 .66.27 1.3.73 1.77l6.06 6.06c.39.39 1.02.39 1.41 0l4.59-4.59a.996.996 0 0 0 0-1.41L7.73 1.73zM2.38 7.09c-.31-.3-.47-.7-.47-1.13V3.5c0-.88.72-1.59 1.59-1.59h2.47c.42 0 .83.16 1.13.47l6.14 6.13-4.73 4.73-6.13-6.15zM3.01 3h2v2H3V3h.01z"></path>

        return $image;


    }

}