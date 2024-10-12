package com.example.gofuel.repository.pump;


import com.example.gofuel.model.pump.Pump;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IPumpDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<Pump>> getPumps();
    }

    // Local data source
    interface Local {
        ResultWrapper<Pump> getCachedPump();
    }

    interface Main extends Remote, Local {}
}
