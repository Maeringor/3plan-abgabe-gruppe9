package de.prj1.planspringapp.mapper;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import de.prj1.planspringapp.dto.Token;

public class TokenMapper implements RowMapper<Token>{

    @Override
    public Token mapRow(ResultSet rs, int rowNum) throws SQLException {
        Token token = new Token();

        token.setId(rs.getInt("toid"));
        token.setUid(rs.getInt("kuid"));
        token.setToken(rs.getString("token"));
        token.setCreatedAt(rs.getTimestamp("tcreatedAt"));
        token.setConfirmed(rs.getBoolean("tconfirmed"));
        token.setSent(rs.getBoolean("tsent"));


        return token;
    }
    
}
