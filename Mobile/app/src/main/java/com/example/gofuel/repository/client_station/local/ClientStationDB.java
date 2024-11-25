package com.example.gofuel.repository.client_station.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.item.Item;

import java.util.List;

@Dao
public interface ClientStationDB {
    @Insert
    void addAll(List<ClientStation> favoriteStation);

    @Query("SELECT * FROM client_station")
    List<ClientStation> getFavoriteStation();

    @Query("DELETE FROM client_station")
    void deleteAll();
}
