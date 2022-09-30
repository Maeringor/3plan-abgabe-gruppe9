package de.prj1.planspringapp.dao;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Component;

import de.prj1.planspringapp.dto.Token;
import de.prj1.planspringapp.mapper.TokenMapper;
import lombok.extern.slf4j.Slf4j;

@Component
@Slf4j
public class GetTokenDAO {
    @Value("${db.tokenTable}")
    private String tokenTab;

    @Autowired
    private JdbcTemplate jdbcTemplate;
    private String GET_TOKEN_SQL = "SELECT * FROM %s";
    
    
    public List<Token> getToken(){
        log.info(String.format(GET_TOKEN_SQL, tokenTab));
        return jdbcTemplate.query(String.format(GET_TOKEN_SQL, tokenTab),
         new TokenMapper());
    
    }

    public void updateTokenSended(Token token){
        jdbcTemplate.update("update " + tokenTab + " set tsent = 1 where TOID = ?", token.getId());
    }

    public void deleteToken(Token token){
        jdbcTemplate.update("DELETE FROM " + tokenTab + " WHERE TOID = ?", token.getId());
    }
}
