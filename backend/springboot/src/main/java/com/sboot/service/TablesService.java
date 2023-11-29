package com.sboot.service;

import com.sboot.model.Tables;
import com.sboot.repository.TablesRepository;

import jakarta.persistence.EntityNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class TablesService {
    @Autowired
    TablesRepository tablesRepository;

    public List<Tables> getTables(){
        return tablesRepository.findAll();
    }

    public Optional<Tables> getTable(Long id){
        return tablesRepository.findById(id);
    }
}