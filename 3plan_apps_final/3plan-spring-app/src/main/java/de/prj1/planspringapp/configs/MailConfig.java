    package de.prj1.planspringapp.configs;

    import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.context.annotation.Configuration;

    import lombok.Getter;
    import lombok.Setter;

    @Configuration
    @ConfigurationProperties(prefix = "mail")
    @Getter
    @Setter
    public class MailConfig {
        
        private String host;
        private int port;
        private String from;

    }