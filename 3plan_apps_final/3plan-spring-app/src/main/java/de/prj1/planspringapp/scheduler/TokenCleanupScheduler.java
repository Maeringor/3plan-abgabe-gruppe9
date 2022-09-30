package de.prj1.planspringapp.scheduler;

import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

import org.springframework.context.annotation.Configuration;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;

import de.prj1.planspringapp.dao.GetTokenDAO;
import de.prj1.planspringapp.dto.Token;

@Configuration
@EnableScheduling
public class TokenCleanupScheduler {

    private List<Token> tokenlist = new ArrayList<Token>();

    private Timestamp deleteTime;
    private LocalDateTime time;

    private final GetTokenDAO getTokenDAO;

    public TokenCleanupScheduler(GetTokenDAO getTokenDAO) {
        this.getTokenDAO = getTokenDAO;
    }

    @Scheduled(cron = "0 */5  * * * *")
    public void deleteToken() {
        tokenlist = getTokenDAO.getToken();

        Long datetime = System.currentTimeMillis();
        Timestamp currentTimestamp = new Timestamp(datetime);

        for (Token token : tokenlist) {

            deleteTime = timeToDelete(token);

            if (token.isConfirmed() || deleteTime.before(currentTimestamp)) {
                getTokenDAO.deleteToken(token);
            }
        }
    }

    private Timestamp timeToDelete(Token token) {
        deleteTime = token.getCreatedAt();
        time = deleteTime.toLocalDateTime().plusMinutes(15);
        deleteTime = Timestamp.valueOf(time);
        return deleteTime;

    }
}
