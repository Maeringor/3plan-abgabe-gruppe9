package de.prj1.planspringapp.dao;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Component;

import de.prj1.planspringapp.dto.User;
import de.prj1.planspringapp.mapper.UserMapper;
import lombok.extern.slf4j.Slf4j;

@Component
@Slf4j
public class GetUserDAO {
    
    @Value("${db.userTable}")
    private String userTab;

    @Autowired
    private JdbcTemplate jdbcTemplate;

    private String GET_USERS_SQL = "SELECT * FROM %s";
    
    public List<User> getUser() {
        log.info(String.format(GET_USERS_SQL, userTab));
        return jdbcTemplate.query(String.format(GET_USERS_SQL, userTab),
            new UserMapper());
    
    }

    
}
