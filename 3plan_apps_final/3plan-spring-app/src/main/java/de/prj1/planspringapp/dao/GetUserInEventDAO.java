package de.prj1.planspringapp.dao;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Component;

import de.prj1.planspringapp.dto.Event;
import de.prj1.planspringapp.dto.UserInEvent;
import de.prj1.planspringapp.mapper.UserInEventMapper;
import lombok.extern.slf4j.Slf4j;

@Component
@Slf4j
public class GetUserInEventDAO {
    
    @Value("${db.userInEventTable}")
    private String userInEventTable;

    @Autowired
    private JdbcTemplate jdbcTemplate;

    private String GET_USERINEVENT_SQL = "SELECT * FROM %s";
    private String GET_USERINONEEVENT_SQL = "SELECT * FROM %s WHERE EVID = %s";

    public List<UserInEvent> getUserInEvent(){
        log.info(String.format(GET_USERINEVENT_SQL, userInEventTable));
        return jdbcTemplate.query(String.format(GET_USERINEVENT_SQL, userInEventTable),
        new UserInEventMapper());
    }

    public List<UserInEvent> getUserInOneEvent(Event event){
        log.info(String.format(GET_USERINONEEVENT_SQL, userInEventTable, event.getId()));
        return jdbcTemplate.query(String.format(GET_USERINONEEVENT_SQL, userInEventTable, event.getId()),
        new UserInEventMapper());
    }
}
