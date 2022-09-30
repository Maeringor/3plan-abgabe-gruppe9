package de.prj1.planspringapp.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import de.prj1.planspringapp.dto.Event;

public class EventMapper implements RowMapper<Event>{

    @Override
    public Event mapRow(ResultSet rs, int rowNum) throws SQLException {
        Event event = new Event();

        event.setId(rs.getInt("EVID"));
        event.setOwnerId(rs.getInt("KUID"));
        event.setStart(rs.getTimestamp("EVStart"));
        event.setTitle(rs.getString("EvTitle"));
        

        return event;
    }
    
}
