package de.prj1.planspringapp.dto;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

@AllArgsConstructor
@NoArgsConstructor
@Getter
@Setter
public class UserInEvent {
    
    private int userInEventID;
    private int eventID;
    private int userID;
}
