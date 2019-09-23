<?php $this->load->view('header'); ?>
        <div class="painel">
            <h2><?php echo $h2; ?></h2>
            <?php
                if($msg = get_msg()):
                    echo '<div class="msg-box">'.$msg.'</div>';
                endif;
                echo form_open();
                echo form_label('Nome para login:', 'login');
                echo form_input('login', set_value('login'), array('autofocus' => 'autofocus'));
                
                echo form_label('Senha', 'senha');
                echo form_password('senha', set_value('senha'));
                
                echo form_label('Repita a Senha', 'senha2');
                echo form_password('senha2', set_value('senha2'));
                
                echo form_submit('enviar', 'Salvar dados', array('class' => 'botao'));
                echo form_close();
            ?>
        </div>
<?php $this->load->view('footer'); ?>