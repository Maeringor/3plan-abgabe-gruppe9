package de.prj1.planspringapp.scheduler;

import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

import org.springframework.context.annotation.Configuration;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;

import de.prj1.planspringapp.dao.GetEventDAO;
import de.prj1.planspringapp.dto.Event;

@Configuration
@EnableScheduling
public class DeleteEventScheduler {

    private List<Event> eventlist = new ArrayList<Event>();

    private Timestamp deleteTime;
    private LocalDateTime time;

    private final GetEventDAO getEventDAO;

    public DeleteEventScheduler(GetEventDAO getEventDAO) {
        this.getEventDAO = getEventDAO;
    }

    @Scheduled(cron = "0 */5  * * * *")
    public void deleteEvent() {
        eventlist = getEventDAO.getEvents();

        Long datetime = System.currentTimeMillis();
        Timestamp currentTimestamp = new Timestamp(datetime);

        for (Event event : eventlist) {

            deleteTime = timeToDelete(event);

            if (deleteTime.before(currentTimestamp)) {
                getEventDAO.deleteEvent(event);
            }

        }
    }

    private Timestamp timeToDelete(Event event) {
        deleteTime = event.getStart();
        time = deleteTime.toLocalDateTime().plusHours(2);
        deleteTime = Timestamp.valueOf(time);
        return deleteTime;

    }
}
