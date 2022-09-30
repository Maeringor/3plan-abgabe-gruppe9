package de.prj1.planspringapp.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import de.prj1.planspringapp.dto.UserInEvent;

public class UserInEventMapper implements RowMapper<UserInEvent>{

    @Override
    public UserInEvent mapRow(ResultSet rs, int rowNum) throws SQLException {
        UserInEvent userInEvent = new UserInEvent();

        userInEvent.setUserInEventID(rs.getInt("EVKUID"));
        userInEvent.setEventID(rs.getInt("EVID"));
        userInEvent.setUserID(rs.getInt("KUID"));   

        return userInEvent;
    }
    
}
