<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DrugModalComponent extends Component
{
    public $modalId;
    public $modalTitle;
    public $nameId;
    public $nameValue;
    public $priceId;
    public $priceValue;
    public $quantityId;
    public $quantityValue;
    public $descriptionId;
    public $descriptionValue;
    public $previewContainerId;
    public $previewImageId;
    public $imageSrc;
    public $imageHidden;
    public $fileInputId;
    public $fileInputRequired;
    public $actionFunction;
    public $actionButtonText;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $modalId,
        string $modalTitle,
        string $nameId,
        string $priceId,
        string $quantityId,
        string $descriptionId,
        string $previewContainerId,
        string $previewImageId,
        string $fileInputId,
        string $actionFunction,
        string $actionButtonText,
        string $nameValue = '',
        string $priceValue = '',
        string $quantityValue = '',
        string $descriptionValue = '',
        string $imageSrc = '',
        bool $imageHidden = true,
        bool $fileInputRequired = false
    ) {
        $this->modalId = $modalId;
        $this->modalTitle = $modalTitle;
        $this->nameId = $nameId;
        $this->nameValue = $nameValue;
        $this->priceId = $priceId;
        $this->priceValue = $priceValue;
        $this->quantityId = $quantityId;
        $this->quantityValue = $quantityValue;
        $this->descriptionId = $descriptionId;
        $this->descriptionValue = $descriptionValue;
        $this->previewContainerId = $previewContainerId;
        $this->previewImageId = $previewImageId;
        $this->imageSrc = $imageSrc;
        $this->imageHidden = $imageHidden;
        $this->fileInputId = $fileInputId;
        $this->fileInputRequired = $fileInputRequired;
        $this->actionFunction = $actionFunction;
        $this->actionButtonText = $actionButtonText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drug-modal-component');
    }
}
