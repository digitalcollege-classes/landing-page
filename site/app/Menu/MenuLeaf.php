<?php

class MenuLeaf implements MenuComponent {
    private string $label;
    private string $url;
    private ?string $icon = null;
    private bool $isSubItem = false;

    public function __construct(string $label, string $url, ?string $icon = null, bool $isSubItem = false) {
        $this->label = $label;
        $this->url   = $url;
        $this->icon  = $icon;
        $this->isSubItem = $isSubItem;
    }

    public function render(): string {
        $iconHtml = $this->icon ? "<i class='bi bi-{$this->icon} me-2'></i>" : '';
        $linkClass = $this->isSubItem ? 'dropdown-item' : 'nav-link';
        return "<li class='nav-item'>" .
               "<a class='{$linkClass}' href='" . htmlspecialchars($this->url) . "'>" .
               $iconHtml .
               htmlspecialchars($this->label) .
               "</a>" .
               "</li>";
    }

    

    public function add(MenuComponent $component): void {
      
    }

    public function getChildren(): array {
    return [];
}
}