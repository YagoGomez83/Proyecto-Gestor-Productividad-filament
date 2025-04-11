<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heatmap extends Component
{
    public $heatData;
    public $defaultLat;
    public $defaultLng;
    public $popupUrl;
    public $radius;
    public $blur;
    public $minOpacity;
    public $markerRadius;
    public $mapHeight;
    public $mapId;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $heatData = [],
        $popupUrl = null,
        $defaultLat = -33.301726,
        $defaultLng = -66.337752,
        $radius = 25,
        $blur = 15,
        $minOpacity = 0.5,
        $markerRadius = 30,
        $mapHeight = '500px',
        $mapId = 'heatmap'
    )
    {
        $this->heatData = $heatData;
        $this->defaultLat = $defaultLat;
        $this->defaultLng = $defaultLng;
        $this->popupUrl = $popupUrl;
        $this->radius = $radius;
        $this->blur = $blur;
        $this->minOpacity = $minOpacity;
        $this->markerRadius = $markerRadius;
        $this->mapHeight = $mapHeight;
        $this->mapId = $mapId;
      
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.heatmap');
    }
}
