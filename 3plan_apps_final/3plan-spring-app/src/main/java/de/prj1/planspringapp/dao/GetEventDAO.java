package de.prj1.planspringapp.dao;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Component;

import de.prj1.planspringapp.dto.Event;
import de.prj1.planspringapp.mapper.EventMapper;
import lombok.extern.slf4j.Slf4j;

@Component
@Slf4j
public class GetEventDAO {
    @Value("${db.eventTable}")
    private String eventTab;

    @Autowired
    private JdbcTemplate jdbcTemplate;
    private String GET_EVENTS_SQL = "SELECT * FROM %s";

    
    public List<Event> getEvents(){
        log.info(String.format(GET_EVENTS_SQL, eventTab));
        return jdbcTemplate.query(String.format(GET_EVENTS_SQL, eventTab),
         new EventMapper());
    
    }

    public void deleteEvent(Event event){
        jdbcTemplate.update("DELETE FROM " + eventTab + " WHERE EVID = ?", event.getId());
    }
}
