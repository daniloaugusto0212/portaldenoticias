<?php
    include('../config.php');
    $data = [];
    $assunto = 'Nova mensagem do site.';
    $corpo = '';
    foreach ($_POST as $key => $value) {
        $corpo.=ucfirst($key).": ".$value;
        $corpo.="<hr>";
    }
    $info = array('assunto'=>$assunto,'corpo'=>$corpo);
    $mail = new Email('smtp.hostinger.com.br','contato@sitedan.com.br','*****','Notícias Now');
    $mail->addAdress('contato@sitedan.com.br','Notícias Now');                
    $mail->formatarEmail($info);
    if ($mail->enviarEmail()) { 
        $data['sucesso'] = true;
    }else{
        $data['erro'] = true;
    } 

    //$data['retorno'] = 'Sucesso!';
    
    die(json_encode($data));

?>