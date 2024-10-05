package com.example.gofuel.repository.station;

import com.example.gofuel.model.Station;
import com.example.gofuel.repository.common.ResultWrapper;

public interface IStationDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<Station> getStation();
    }

    // Local data source
    interface Local {
        ResultWrapper<Station> getCachedStation();
    }

    interface Main extends Remote, Local {}
}
