package com.sboot.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.sboot.model.Turns;
import com.sboot.repository.TurnsRepository;

@Service
public class TurnsService {

    @Autowired
    private TurnsRepository turnsRepository;

    public List<Turns> getTurnsAvaibles(int people, String date_pick, int rest){
        return turnsRepository.findTurnsAvaibles(people, date_pick, rest);
    }

}
