package de.prj1.planspringapp.dto;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@AllArgsConstructor
@NoArgsConstructor
@Getter
@Setter
public class User {

    private int id;
    private String username;
    private String name;
    private String email;
    private boolean enabled;
}
