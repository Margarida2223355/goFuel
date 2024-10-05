package com.example.gofuel.repository.station;

import com.example.gofuel.model.Station;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IStationDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<Station>> getStations();
    }

    // Local data source
    interface Local {
        ResultWrapper<Station> getCachedStation();
    }

    interface Main extends Remote, Local {}
}
