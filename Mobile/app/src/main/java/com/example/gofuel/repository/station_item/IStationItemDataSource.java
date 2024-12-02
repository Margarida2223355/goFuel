package com.example.gofuel.repository.station_item;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IStationItemDataSource {
        interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<StationItem>> getStationItems();
        ResultWrapper<List<StationItem>> getStationItems(Station station);
    }

    // Local data source
    interface Local {
        ResultWrapper<StationItem> getCachedItem();
    }

    interface Main extends IStationItemDataSource.Remote, IStationItemDataSource.Local {}
}
