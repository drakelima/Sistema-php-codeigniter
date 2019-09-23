<?php $this->load->view('header'); ?>

            <content class="container">
                    <div class="row">
                        <table class="table table-striped fontes-custom col-12">
                        <thead>
                            <tr>
                            <th scope="col">Comarca</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Tipo de estágio</th>
                            <th class="alinha-centro menor" scope="col1">Vaga(s)</th>
                            <th scope="col" class="alinha-centro">Inscrições</th>
                            <th scope="col">Documento(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            //printInfoDump($noticia_arquivos);
                            if(isset($noticia_arquivos)){
                                foreach($noticia_arquivos as $linha):
                            ?>
                            <tr>
                            <td class="col-2"><?php echo to_html($linha['comarca']); ?></td>
                            <td class="col-2"><?php echo to_html($linha['unidade']); ?></td>
                            <td class="col-2"><?php echo to_html($linha['tipo_estagio']); ?></td>
                            <td class="alinha-centro col-1"><?php echo to_html($linha['vagas']); ?></td>
                            <td class="alinha-centro col-2">De <?php echo to_html($linha['inicio_inscricao']); ?> á <?php echo to_html($linha['fim_inscricao']); ?></td>
                            <td class="col-4">
                                <?php if(isset($linha['arquivos'])){
                                foreach ($linha['arquivos'] as $arquivo) { ?>
                                    <a class="arquivos_registro" target="_blank"  href="<?php echo base_url('uploads/'.$arquivo); ?>"> <?php echo $arquivo; ?></a><br/><br/>
                                <?php } }
                                else{
                                    echo '<p class="branco">Nenhum arquivo cadastrado!</p>';
                                }
                                ?>
                            </td>
                            </tr>
                            <?php 
                                endforeach;
                            } 
                            else{
                                echo '<p class="centraliza">Nenhuma notícia cadastrada!</p>';
                            }
                            ?>
                        
                        </tbody>
                        
                        </table>
                    </div>
                
                
            </content>
                
<?php $this->load->view('footer'); ?>