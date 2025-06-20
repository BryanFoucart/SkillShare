<?php

declare(strict_types=1);

namespace App\service;

class MailService
{
    public static function sendEmailVerification(string $email, string $token)
    {
        $link = "http://localhost:3001/verify-email?token=$token";

        $subject = "🔐 Veuillez vérifier votre adresse électronique";
        $message = "        <html>
        <head>
            <title>Vérifiez votre adresse électronique</title>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
            <table cellpadding='0' cellspacing='0' width='100%' style='background-color: #f4f4f4; padding: 40px 0;'>
                <tr>
                    <td align='center'>
                        <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);'>
                            <tr>
                                <td style='background-color: #007bff; padding: 20px; text-align: center; color: #fff;'>
                                    <h1 style='margin: 0; font-size: 24px;'>SkillShare</h1>
                                    <p style='margin: 5px 0 0;'>Confirmez votre adresse électronique</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding: 30px; color: #333333; font-size: 16px;'>
                                    <p style='margin-top: 0;'>Bonjour 👋,</p>
                                    <p>Merci d'avoir créé un compte avec <strong>SkillShare</strong>.</p>
                                    <p>Pour compléter votre inscription, veuillez vérifier votre adresse électronique en cliquant sur le bouton ci-dessous :</p>
                                    <p style='text-align: center; margin: 30px 0;'>
                                        <a href='{$link}' style='background-color: #28a745; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Vérifier l'email</a>
                                    </p>
                                    <p>Si le bouton ci-dessus ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :</p>
                                    <p style='word-break: break-all; color: #555;'>{$link}</p>
                                    <p>Si vous n'avez pas créé ce compte, vous pouvez ignorer cet email.</p>
                                    <p style='margin-bottom: 0;'>Sincères salutations,<br>L'équipe SkillShare</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='background-color: #f1f1f1; text-align: center; padding: 20px; font-size: 12px; color: #999999;'>
                                    © " . date('Y') . " SkillShare. Tous droits réservés.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        // Proper headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: SkillShare <noreply@skillshare.com>\r\n";

        // Send the email";
        mail($email, $subject, $message, $headers);
    }
    /**
     * Envoie un lien de réinitialisation du mot de passe
     * @param string $email
     * @param string $token
     */
    public static function sendPasswordResetEmail(string $email, string $token): void
    {
        $link = "http://localhost:3001/reset-password?token=" . urlencode($token);

        $subject = "Réinitialisation de votre mot de passe SkillSwap";
        $message = "Vous avez demandé une réinitialisation de mot de passe. Cliquez ici pour le réinitialiser : $link\n\n";
        $message .= "Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.";

        mail($email, $subject, $message, "From: noreply@skillswap.local");
    }
}
