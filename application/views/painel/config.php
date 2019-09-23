<div class="painel_logado">
        <h2>Alterar as configurações de acesso</h2>
        <?php
        if($msg = get_msg()){
            if($msg == 'Dados alterados com sucesso!'){
                echo 
                '<div class="msg_box_listagem preto alert alert-success alert-dismissible fade show">'
                    .$msg.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>';
            }else{
                echo 
                '<div class="msg_box_listagem preto alert alert-danger alert-dismissible fade show">'
                    .$msg.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>';
            }
        }
            
            echo form_open();
            
            echo form_label('Nome para login:', 'login');
            echo form_input('login', set_value('login'), array('autofocus' => 'autofocus'));
            
            echo form_label('Nova senha', 'senha');
            echo form_password('senha');
            
            echo form_label('Repita a Senha', 'senha2');
            echo form_password('senha2');
            
            echo form_submit('enviar', 'Alterar dados', array('class' => 'botao'));
            echo form_close();
        ?>
</div>