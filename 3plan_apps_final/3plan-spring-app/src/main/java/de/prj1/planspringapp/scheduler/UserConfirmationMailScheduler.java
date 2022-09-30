package de.prj1.planspringapp.scheduler;

import java.util.ArrayList;
import java.util.List;

import org.springframework.context.annotation.Configuration;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;

import de.prj1.planspringapp.dao.GetTokenDAO;
import de.prj1.planspringapp.dao.GetUserDAO;
import de.prj1.planspringapp.dto.Token;
import de.prj1.planspringapp.dto.User;
import de.prj1.planspringapp.services.JavaMailSenderService;

@Configuration
@EnableScheduling
public class UserConfirmationMailScheduler {

    private List<Token> tokenlist = new ArrayList<Token>();
    private List<User> userlist = new ArrayList<User>();

    private final GetUserDAO getUserDAO;
    private final GetTokenDAO getTokenDAO;

    private final JavaMailSenderService mailSenderService;

    public UserConfirmationMailScheduler(GetUserDAO getUserDAO, GetTokenDAO getTokenDAO,
            JavaMailSenderService mailSenderService) {
        this.getUserDAO = getUserDAO;
        this.getTokenDAO = getTokenDAO;
        this.mailSenderService = mailSenderService;
    }

    @Scheduled(cron = "0 * * * * *")
    public void sendNewToken() {
        tokenlist = getTokenDAO.getToken();
        userlist = getUserDAO.getUser();

        for (Token token : tokenlist) {
            if (!token.isSent()) {

                sendAndUpdateToken(token);

            }
        }
    }

    private void sendAndUpdateToken(Token token) {
        for (User user : userlist) {
            if (user.getId() == token.getUid() && !user.isEnabled()) {
                mailSenderService.sendMail(user.getEmail(), subjectText(), mailText(user, token));
                token.setSent(true);
                getTokenDAO.updateTokenSended(token);
            }
        }
    }

    private String mailText(User user, Token token){
        String text = "Dear " + user.getName() + 
        ",\n\nin this email is the code for verify your account. Enter this code on our site within the next 15 minutes to verify yourself.\n\nToken: "
        + token.getToken() +
        "\n\nThank you very much for your support.\n\nThe 3Plan Team.";

        return text;
    }

    private String subjectText(){
        return "Verify your account";
    }
}
