package de.prj1.planspringapp.dto;

import java.sql.Timestamp;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@AllArgsConstructor
@NoArgsConstructor
@Getter
@Setter
public class Token {

    private int id;
    private int uid;
    private String token;
    private Timestamp createdAt;
    private boolean confirmed;
    private boolean sent;
}
