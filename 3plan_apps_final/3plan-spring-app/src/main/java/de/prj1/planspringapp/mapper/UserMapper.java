package de.prj1.planspringapp.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import de.prj1.planspringapp.dto.User;

public class UserMapper implements RowMapper<User>{

    @Override
    public User mapRow(ResultSet rs, int rowNum) throws SQLException {
        User user = new User();

        user.setId(rs.getInt("KUID"));
        user.setUsername(rs.getString("KUname"));
        user.setName(rs.getString("KName"));
        user.setEmail(rs.getString("Kmail"));
        user.setEnabled(rs.getBoolean("enabled"));

        return user;
    }
    
}
