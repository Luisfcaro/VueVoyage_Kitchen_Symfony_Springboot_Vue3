package com.sboot.controller;

import com.sboot.model.Tables;
import com.sboot.service.TablesService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping(path = "tables")
public class TablesController {

    @Autowired
    private TablesService tablesService;

    @GetMapping
    public List<Tables> getAll() {
        return tablesService.getTables();
    }

    @GetMapping("/{tableId}")
    public Optional<Tables> getAll(@PathVariable("tableId") Long id) {
        return tablesService.getTable(id);
    }

}