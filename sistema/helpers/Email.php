<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para envio de e-mails de forma rápida 
 */

require_once(ROOT . '/libs/PHPMailer/class.phpmailer.php'); //a lib PHPMailer não possui namespace

class Email
{
    //propriedades
    private $smtpServidor;
    private $smtpUsuario;
    private $smtpSenha;
    private $smtpPorta;
    private $remetente;
    private $momeRemetente;
    private $destinatario;
    private $assunto;
    private $mensagem;
    
    function EmailHelper ($smtpServidor, $smtpPorta, $smtpUsuario, $smtpSenha, $destinatario, $remetente, $nomeRemetente, $assunto, $mensagem) 
    {
        $this->smtpServidor = $smtpServidor;
        $this->smtpUsuario = $smtpUsuario;
        $this->smtpSenha = $smtpSenha;
        $this->destinatario = $destinatario;
        $this->remetente = $remetente;
        $this->nomeRemetente = $nomeRemetente;
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
 
        if ($smtpPorta == "") 
            $this->smtpPorta = 25;
		else 
            $this->smtpPorta = $smtpPorta;
    }
    
    public function enviaEmail()
    {
        $mail = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->Host = $this->smtpServidor;
        $mail->SMTPAuth = true; 
        $mail->Username = $this->smtpUsuario;
        $mail->Password = $this->smtpSenha;
        $mail->From = $this->remetente;
        $mail->FromName = $this->nomeRemetente;
        $mail->AddAddress($this->destinatario);
        $mail->WordWrap = 50;
        $mail->IsHTML(false); 
        $mail->Subject = $this->assunto;
        $mail->Body = $this->mensagem;
        
        try
        {
            return $mail->Send();
        }
        catch (phpmailerException $pex)
        {
            throw $pex;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }
	
	public function enviarEmailSimples()
	{
		$email_headers = implode ( "\n",array ( "From: $this->Remetente", "Reply-To: $this->Remetente", "Subject: $this->Assunto", "Return-Path: $this->Remetente", "MIME-Version: 1.0", "X-Priority: 3", "Content-Type: text/html; charset=UTF-8"));
	
		try
		{
			return mail ($this->Destinatario, $this->Assunto, nl2br($this->Mensagem), $email_headers);
		}		
		catch(Exception $ex)
		{
			throw $ex;
		}
	}
}