<?php

class AdminMenuBuilder {
    public static function build(): MenuComposite {
        $root = new MenuComposite("Admin Menu"); 

        $usuarios = new MenuComposite("Usuários", "people");
        $usuarios->add(new MenuLeaf("Cadastrar usuário", "/admin/usuarios/cadastrar",null, true));
        $usuarios->add(new MenuLeaf("Listar usuários", "/admin/usuarios/listar",null, true));
        $root->add($usuarios);
        

        $palestrantes = new MenuComposite("Palestrantes", "person-badge");
        $palestrantes->add(new MenuLeaf("Cadastrar palestrante", "/admin/palestrantes/cadastrar",null, true));
        $palestrantes->add(new MenuLeaf("Listar palestrantes", "/admin/palestrantes/listar",null, true));
        $root->add($palestrantes);
        
  
        $palestras = new MenuComposite("Palestras", "mic");
        $palestras->add(new MenuLeaf("Cadastrar palestra", "/admin/palestras/cadastrar",null, true));
        $palestras->add(new MenuLeaf("Listar palestras", "/admin/palestras/listar",null, true));
        $root->add($palestras);
        
      
        $patrocinadores = new MenuComposite("Patrocinadores", "building");
        $patrocinadores->add(new MenuLeaf("Cadastrar patrocinador", "/admin/patrocinadores/cadastrar",null, true));
        $patrocinadores->add(new MenuLeaf("Listar patrocinadores", "/admin/patrocinadores/listar",null, true));
        $root->add($patrocinadores);
        
        
        $root->add(new MenuLeaf("Voltar pro site", "/", "box-arrow-left"));

        return $root;
    }
}