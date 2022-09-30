package de.prj1.planspringapp.configs;
import java.util.Properties;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.JavaMailSenderImpl;

@Configuration
public class JavaMailSenderConf {

	@Value("${spring.mail.username}")
	private String username;

	@Value("${spring.mail.password}")
	private String password;

	private final MailConfig mailConfig;

	public JavaMailSenderConf(MailConfig mailConfig) {
		this.mailConfig = mailConfig;
	}

	@Bean
	public JavaMailSender mailSender() {
		JavaMailSenderImpl mailSender = new JavaMailSenderImpl();

		mailSender.setHost(mailConfig.getHost());
		mailSender.setPort(mailConfig.getPort());
		mailSender.setUsername(username);
		mailSender.setPassword(password);

		Properties javaMailProperties = mailSender.getJavaMailProperties();
		javaMailProperties.put("mail.transport.protocol", "smtp");
    	javaMailProperties.put("mail.smtp.auth", "true");
    	javaMailProperties.put("mail.smtp.starttls.enable", "true");
    	javaMailProperties.put("mail.debug", "true");

		return mailSender;
	}

}

