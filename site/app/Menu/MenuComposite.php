<?php

class MenuComposite implements MenuComponent {
    private string $label;
    private array $children = [];
    private ?string $icon = null;

    public function __construct(string $label, ?string $icon = null) {
        $this->label = $label;
        $this->icon  = $icon;
    }

    public function add(MenuComponent $component): void {
        $this->children[] = $component;
    }

    public function render(): string
{
    $iconHtml = $this->icon ? '<i class="bi bi-' . $this->icon . ' me-2"></i>' : '';
    
    $html = '<li class="nav-item dropdown">';
    $html .= '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
    $html .= $iconHtml . htmlspecialchars($this->label);
    $html .= '</a>';
    
    $html .= '<ul class="dropdown-menu">';
    
    foreach ($this->children as $child) {
        $html .= $child->render();  
    }
    
    $html .= '</ul>';
    $html .= '</li>';
    
    return $html;
}

    public function getChildren(): array {
    return $this->children;
}
}

