<div>
    <a class= "btn btn-secondary margem" href = "<?php echo base_url('noticia/cadastrar') ?>">INSERIR NOVO REGISTRO</a>
    
        <?php
       
            if($msg = get_msg()):
                //echo '<div class="msg_box_listagem preto">'.$msg.'</div>';
            endif;
            switch($tela):
                case 'listar':
                    if($msg){
                        echo 
                        '<div class="msg_box_listagem preto alert alert-success alert-dismissible fade show">'
                            .$msg.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>';
                    }
                    echo '<h2 class="preto"><div class="msg_box_listagem preto ">'.$h2.'</div></h2>';
                    if(isset($noticias) && sizeof($noticias) > 0):
                        ?>
                    <table class="table table-sm table-striped margem">
                        <thead>
                            <th>Comarca</th>
                            <th>Unidade</th>
                            <th>Tipo de estágio</th>
                            <th>Vagas</th>
                            <th>Periodo</th>
                            <th>Arquivo(s)</th>
                            <th>Operações</th>
                        </thead>
                    <tbody>
                        <?php
                            foreach ($noticia_arquivos as $linha):
                                ?>
                                <tr>
                                    <td><?php echo $linha['comarca']; ?></td>
                                    <td><?php echo $linha['unidade']; ?></td>
                                    <td><?php echo $linha['tipo_estagio']; ?></td>
                                    <td><?php echo $linha['vagas']; ?></td>
                                    <td> De <?php echo $linha['inicio_inscricao']; ?> á <?php echo $linha['fim_inscricao']; ?></td>
                                    <td>
                                        <?php 
                                        if(isset($linha['arquivos'])){
                                        foreach ($linha['arquivos'] as $arquivo) { ?>
                                            <a class="link_arquivo" target="_blank"  href="<?php echo base_url('uploads/'.$arquivo); ?>"> <?php echo $arquivo; ?></a>
                                        <?php }}
                                            else{
                                                echo '<small><p>Nenhum Arquivo Cadastrado!</p></small>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo anchor('noticia/editar/'.$linha['id'], 'Editar'); ?> | 
                                    <a href="<?= base_url('noticia/excluir/'.$linha['id']) ?>" data-toggle="modal" data-target="#modalExemplo">Excluir</a>
                                </tr>
                                <?php
                            endforeach;
                        ?>
                    </tbody>
                    </table>
                    <?php
                else:
                    echo '<div class="msg-box preto">Nenhum registro encontrado!</div>';
                endif;
                break;
                case 'cadastrar':
                    if($msg){
                        echo 
                        '<div class="msg_box_listagem preto alert alert-danger alert-dismissible fade show">'
                            .$msg.
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></div>';
                    }
                    echo '<h2 class="preto"><div class="preto">'.$h2.'</div></h2>';
                    ?>
                    <div class="formulario">
                        <?php
                        echo form_open_multipart();
                        echo form_label('Comarca:', 'comarca');
                        echo form_input('comarca', set_value('comarca'));
                        echo form_label('Unidade:', 'unidade');
                        echo form_input('unidade', set_value('unidade'));
                        $atributos_radio1 = array(
                            "name"=>"tipo_estagio", 
                            'checked '=>'true',
                            'value'=>'Graduação',
                        );
                        $atributos_radio2 = array(
                            "name"=>"enviar", 
                            'checked '=>'true',
                            'value'=>'Graduação',
                        );
                        $inicio_inscricao = array(
                            'name' => "inicio_inscricao",
                            'id' => "inicio_inscricao",
                            'placeholder' => "00/00/0000",
                        );
                        $fim_inscricao = array(
                            'name' => "fim_inscricao",
                            'id' => "fim_inscricao",
                            'placeholder' => "00/00/0000",
                        );
                        echo form_label('Tipo de estágio:', 'tipo_estagio');
                        echo '<label>';
                        echo form_radio('tipo_estagio', 'Graduação', true, 'class="radio"');
                        echo 'Graduação</label>';
                        echo '<label>';
                        echo form_radio('tipo_estagio', 'Pós-graduação', false, 'class=radio');
                        echo 'Pós-graduação</label>';
                        echo form_radio('tipo_estagio', 'Nível médio', false, 'class=radio');
                        echo 'Nível médio</label>';
                        echo form_label('Quantidade de vagas:', 'vagas');
                        echo form_input('vagas', set_value('vagas'));
                        echo form_label('Inicio da inscrição:', 'inicio_inscricao');
                        echo form_input($inicio_inscricao, set_value('inicio_inscricao'));
                        echo form_label('Fim da inscrição:', 'fim_inscricao');
                        echo form_input($fim_inscricao, set_value('fim_inscricao'));
                        echo form_label('arquivo do registro:', 'arquivos[]');
                        echo form_upload('arquivos[]', 'Escolher arquivo', 'multiple');
                        echo 
                        '
                        <div class="botao_adiciona">
                            <div class="container-add-guias">
                            </div>

                            <div>
                                <button class="adicionarCampoAddGuia" style="cursor:pointer">Adicionar mais arquivos</button>
                            </div>
                        </div>
                        ';
                        $opts = array(
                            "name"=>"enviar", 
                            'class'=>'botao',
                            'value'=>'Salvar',
                        );
                        echo form_submit($opts);
                        echo form_close();
                        ?>
                    </div>
                <?php
                break;
                case 'editar':
                if($msg){
                    if($msg == 'Arquivo excluído!'){
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

                echo '<h2 class="preto"><div class="preto">'.$h2.'</div></h2>';
                ?><div class="formulario">
                <?php

                    //seta o valor booleno no radio_button
                    if(to_html($noticia->tipo_estagio)=='Graduação'){
                        $graduacao = true;
                        $pos_graduacao = false;
                        $nivel_medio = false;
                    }if(to_html($noticia->tipo_estagio)=='Pós-graduação'){
                        $graduacao = false;
                        $pos_graduacao = true;
                        $nivel_medio = false;
                    }if(to_html($noticia->tipo_estagio)=='Nível médio'){
                        $graduacao = false;
                        $pos_graduacao = false;
                        $nivel_medio = true;
                    }

                    $inicio_inscricao = array(
                        'name' => "inicio_inscricao",
                        'id' => "inicio_inscricao_editar",
                        'placeholder' => "00/00/0000",
                        'value' => $noticia->inicio_inscricao,
                    );
                    $fim_inscricao = array(
                        'name' => "fim_inscricao",
                        'id' => "fim_inscricao_editar",
                        'placeholder' => "00/00/0000",
                        'value' => $noticia->fim_inscricao,
                    );

                    echo form_open_multipart();
                    echo form_label('Comarca:', 'comarca');
                    echo form_input('comarca', set_value('comarca', to_html($noticia->comarca)));
                    echo form_label('Unidade:', 'unidade');
                    echo form_input('unidade', set_value('unidade', to_html($noticia->unidade)));
                    echo form_label('Tipo de estágio:', 'tipo_estagio');
                    echo '<label>';
                    echo form_radio('tipo_estagio', 'Graduação', $graduacao, 'class="radio"');
                    echo 'Graduação</label>';
                    echo '<label>';
                    echo form_radio('tipo_estagio', 'Pós-graduação', $pos_graduacao, 'class="radio"');
                    echo 'Pós-graduação</label>';
                    echo form_radio('tipo_estagio', 'Nível médio', $nivel_medio, 'class="radio"');
                    echo 'Nível médio</label>';
                    echo form_label('Quantidade de vagas:', 'vagas');
                    echo form_input('vagas', set_value('vagas', to_html($noticia->vagas)));
                    echo form_label('Inicio da inscrição:', 'inicio_inscricao');
                    echo form_input($inicio_inscricao);
                    echo form_label('Fim da inscrição:', 'fim_inscricao');
                    echo form_input($fim_inscricao);
                    echo form_label('arquivo do registro:', 'arquivos[]');
                    echo form_upload('arquivos[]', 'Escolher arquivo', 'multiple');
                    echo 
                    '
                    <div class="botao_adiciona">
                        <div class="container-add-guias botao_adiciona">
                        </div>
                        <div>
                            <button class="adicionarCampoAddGuia" style="cursor:pointer">Adicionar mais arquivos</button>
                        </div>
                    </div>
                    ';
                    $opts = array(
                        "name"=>"enviar", 
                        'class'=>'botao',
                        'value'=>'Salvar',
                    );
                    echo '<p class="arquivos_gravados"><small class="preto">Arquivos atuais:</small><br />';
                    foreach ($arquivos as $arquivo) {
                    echo '<div class="arquivos_gravados"><small class="organiza"><a target="_blank" href="'
                    .base_url('uploads/'.$arquivo['arquivo']).'" 
                    >'
                        .$arquivo['arquivo'].    
                        
                    '</a></small><small><a data-toggle="modal" data-target="#modalExemplo2" class="btn btn-link link_remover" id="link_removerJs" href="'.base_url('noticia/excluir_arquivo/'.$arquivo['id'].'/'.$noticia->id).'">Remover</a></small><div> </p>';
                }
                    echo form_submit($opts);
                    echo form_close();
                ?>
                    </div>
                <?php
                break;
            endswitch;
            $this->load->view('painel/includes/datepicker');
            //$this->load->view('painel/modais/confirmacao');
            ?>

<script>
$(document).ready(function(){
    $('modalExemplo').click(function() {
        
    });
})
</script> 



<script>

    $(document).ready(function () {

        var max_fields = 10;
        var wrapper = $(".container-add-guias");
        var add_button = $(".adicionarCampoAddGuia");


        $(add_button).click(function (e) {
            e.preventDefault();
            $(wrapper).append('<div class="container-guia-item"><input type="file" name="arquivos[]"><a class="deleta_arquivo";>Remover</a></div>'); //add input box
        });

        $(wrapper).on("click", ".deleta_arquivo", function (e) {
            e.preventDefault();
            $(this).closest('.container-guia-item').remove();
        })
    });

</script>

<!-- Modal Confirmação exclusão notícia-->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação de exclusão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja excluir?
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('noticia/excluir/'.$linha['id']) ?>" type="button" class="btn btn-success">Excluir</a>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirmação exclusão arquivo -->
        <div class="modal fade" id="modalExemplo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmação de exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir?
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('noticia/excluir_arquivo/'.$arquivo['id'].'/'.$noticia->id) ?>" type="button" class="btn btn-success">Excluir</a>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
        </div>


</div>