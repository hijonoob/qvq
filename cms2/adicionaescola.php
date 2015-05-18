<?php
    include 'templates/checaadmin.php';
    include 'templates/header.php';
?>
            <h3> <?php echo _( 'Add school'); ?></h3>
            
            <?php
                include 'restrito/conexao.php';
                if( isset( $_POST['criar'] ) ):
                    $usuario = $_POST['usuario'];
                    $perfil = $_POST['perfil'];
                    $nome = $_POST['nome'];
                    $razao = $_POST['razao'];
                    $cnpj = $_POST['cnpj'];
                    $end = $_POST['end'];
                    $cid = $_POST['cid'];
                    $est = $_POST['est'];
                    $cep = $_POST['cep'];
                    $telFixo = $_POST['telFixo'];
                    $contato = $_POST['contato'];
                    $senha = $_POST['senha'];
                    $target_dir = "uploads/";
                    $nomearquivo = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $target_file = $target_dir . $usuario;
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                    if (file_exists($target_file)) {
                        $uploadOk = 1;
                        $target_file = $target_dir . $usuario . rand(5, 15);
                    }
                     // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                    // if everything is ok, try to upload file
                    } else {
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                    }

                    
                    if ($usuario=='' || $perfil=='' || $nome=='' || $razao=='' || $cnpj=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $telFixo=='' || $contato=='' || $senha=='') {
                        echo "<div class='alert alert-warning'> " . _( 'All fields must be typed') . " </div>";
                    } else {
                        $param = $conexao->prepare("INSERT INTO escolas(usuario, perfil, nome, razao, cnpj, end, cid, est, cep, telFixo, contato, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $param->bind_param('ssssssssiiss', $usuario, $perfil, $nome, $razao, $cnpj, $end, $cid, $est, $cep, $telFixo, $contato, $senha);
                        if ($param->execute()) {
                            echo "<div class='alert alert-success'> " . _( 'Changed successfully') . "  </div>";
                            $param->close();
                        }
                    }
                endif;
            ?>
            
            
            <form action="" method="POST" id="adicionaescola" enctype="multipart/form-data">
                <label for="usuario"> <?php echo _( 'User'); ?>: </label>
                    <input type="text" placeholder=" <?php echo _( 'login username'); ?>" class="form-control" name="usuario" autofocus />
                <label for="perfil">  <?php echo _( 'Profile'); ?>: </label>
                    <input type="text" placeholder=" <?php echo _( 'Access profile - 2 to school - 3 to admin'); ?>" class="form-control" name="perfil" />
                <label for="nome">  <?php echo _( 'Name'); ?>: </label>
                    <input type="text" placeholder=" <?php echo _( 'name of the school'); ?>" class="form-control" name="nome" />

                <label for="razao">  <?php echo _( 'Registered name'); ?>: </label>
                    <input type="text" placeholder=" <?php echo _( 'registered name of the school'); ?>" class="form-control" name="razao" />

                <label for="cnpj">  <?php echo _( 'Registered number'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'cnpj of the school'); ?>" class="form-control" name="cnpj" />
                <label for="end">  <?php echo _( 'Address'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'full address of the school'); ?>" class="form-control" name="end" />
                <label for="cid">  <?php echo _( 'City'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'city of the school'); ?>" class="form-control" name="cid" />
                <label for="est">  <?php echo _( 'State'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'state of the school'); ?>" class="form-control" name="est" />
                <label for="cep">  <?php echo _( 'Zip code'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'zip code of the school'); ?>" class="form-control" name="cep" />
                <label for="telFixo">  <?php echo _( 'Phone'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'phone number of the school'); ?>" class="form-control" name="telFixo" />
                <label for="contato">  <?php echo _( 'Contact'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'name of the contact to talk to the school'); ?>" class="form-control" name="contato" />
                <label for="senha">  <?php echo _( 'Password'); ?>: </label>
                    <input type="text" placeholder="<?php echo _( 'access password of the school'); ?>" class="form-control" name="senha" />
                <label for="fileToUpload">  Avatar </label>
                    <input type="file" name="fileToUpload" id="fileToUpload" placeholer="avatar">

                <input type="submit" name="criar" value=" <?php echo _( 'Add school'); ?>" class="btn btn-default" />   
            </form>     
        </div>  

<?php include 'templates/footer.php' ?>

