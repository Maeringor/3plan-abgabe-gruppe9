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
public class Event {
    private int id;
    private int ownerId;
    private Timestamp start;
    private String title;


}
