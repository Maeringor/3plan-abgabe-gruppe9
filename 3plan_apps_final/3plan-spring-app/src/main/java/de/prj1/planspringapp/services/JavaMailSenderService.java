package de.prj1.planspringapp.services;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.stereotype.Service;

import de.prj1.planspringapp.configs.MailConfig;
import lombok.extern.slf4j.Slf4j;

@Service
@Slf4j
public class JavaMailSenderService {

  private final MailConfig mailConfig;

  public JavaMailSenderService(MailConfig mailConfig) {
		this.mailConfig = mailConfig;
	}

     @Autowired
    private JavaMailSender emailSender;

    public void sendMail(
    String to, String subject, String text) {
        
      SimpleMailMessage message = new SimpleMailMessage(); 
      message.setFrom(mailConfig.getFrom());
      message.setTo(to); 
      message.setSubject(subject); 
      message.setText(text);

      emailSender.send(message);

      log.info("Email sent sucessfully");
      
      }
    }