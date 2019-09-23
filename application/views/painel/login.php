<?php $this->load->view('header'); ?>
        <div class="painel">
            <h2><?php echo '<div class="titulo_login">'.$h2.'</div>' ?></h2>
            <?php
                if($msg = get_msg()):
                    echo '<div class="msg-box">'.$msg.'</div>';
                endif;
                echo form_open();
                echo form_label('login:', 'login', array('class' => 'label_login'));
                echo form_input('login', set_value('login'), array('autofocus' => 'autofocus'));
                
                echo form_label('Senha:', 'senha', array('class' => 'label_login'));
                echo form_password('senha', set_value('senha'));
                
                echo form_submit('enviar', 'Autenticar', array('class' => 'botao_login'));
                echo form_close();
            ?>
        </div>
<?php $this->load->view('footer'); ?>