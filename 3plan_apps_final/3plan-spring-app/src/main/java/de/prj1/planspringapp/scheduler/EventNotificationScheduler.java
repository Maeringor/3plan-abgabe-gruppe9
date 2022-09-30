package de.prj1.planspringapp.scheduler;

import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.springframework.context.annotation.Configuration;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;

import de.prj1.planspringapp.dao.GetEventDAO;
import de.prj1.planspringapp.dao.GetUserDAO;
import de.prj1.planspringapp.dao.GetUserInEventDAO;
import de.prj1.planspringapp.dto.Event;
import de.prj1.planspringapp.dto.User;
import de.prj1.planspringapp.dto.UserInEvent;
import de.prj1.planspringapp.services.JavaMailSenderService;
import lombok.extern.slf4j.Slf4j;

@Configuration
@EnableScheduling
@Slf4j
public class EventNotificationScheduler {

    private List<Event> eventlist = new ArrayList<Event>();
    private List<UserInEvent> userInEventslist = new ArrayList<UserInEvent>();

    private HashMap<Integer, User> userHashMap = new HashMap<Integer, User>();

    private Timestamp notificationTime;

    private final GetEventDAO getEventDAO;
    private final GetUserInEventDAO getUserInEventDAO;
    private final GetUserDAO getUserDAO;
    private final JavaMailSenderService javaMailSender;

    public EventNotificationScheduler(GetEventDAO getEventDAO, GetUserInEventDAO getUserInEventDAO,
            GetUserDAO getUserDAO, JavaMailSenderService javaMailSender) {
        this.getEventDAO = getEventDAO;
        this.getUserInEventDAO = getUserInEventDAO;
        this.getUserDAO = getUserDAO;
        this.javaMailSender = javaMailSender;
    }

    @Scheduled(cron = "0 * * * * *")
    public void notifyUser() {
        log.info("Notification update");

        eventlist = getEventDAO.getEvents();
        userHashMap = convertArrayListToHashMap(getUserDAO.getUser());

        for (Event event : eventlist) {

            String time = LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:00"));
            Timestamp currentTime = Timestamp.valueOf(time);

            if (notificationTime(event).equals(currentTime)) {
                javaMailSender.sendMail(userHashMap.get(event.getOwnerId()).getEmail(), subjectText(event), mailTextOwner(event, userHashMap.get(event.getOwnerId())));

                userInEventslist = getUserInEventDAO.getUserInOneEvent(event);

                for (UserInEvent uInEvent : userInEventslist) {
                    javaMailSender.sendMail(userHashMap.get(uInEvent.getUserID()).getEmail(), subjectText(event), mailText(userHashMap.get(uInEvent.getUserID()), event));
                }
            }
        }
    }

    private Timestamp notificationTime(Event event) {
        notificationTime = Timestamp.valueOf(event.getStart().toLocalDateTime().minusMinutes(30));
        return notificationTime;
    }

    private HashMap<Integer, User> convertArrayListToHashMap(List<User> userlist) {
        HashMap<Integer, User> hashMap = new HashMap<>();
        for (User user : userlist) {
            hashMap.put(user.getId(), user);
        }
        return hashMap;
    }

    private String mailText(User user, Event event){
        String text = "Dear " + user.getName() + 
        ",\n\nthe event " + event.getTitle() + 
        " will start in 30 minutes.\n\nThe 3Plan team";
        
        return text;
    }

    private String mailTextOwner(Event event ,User user){
        String text = "Dear " + user.getName() +
        ",\n\nyour event " + event.getTitle() + 
        " will start in 30 minutes.\n\n The 3Plan team";
        
        return text;
    }

    private String subjectText(Event event){
        return "Remainder for the event " + event.getTitle();
    }
}
