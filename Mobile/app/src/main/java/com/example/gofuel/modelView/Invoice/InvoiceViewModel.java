package com.example.gofuel.modelView.Invoice;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.InvoiceRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class InvoiceViewModel extends ViewModel {
    private final InvoiceRepository invoiceRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public InvoiceViewModel() {
        invoiceRepository = InvoiceRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() {
        return state;
    }

    public void loadPendingInvoices() {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<PendingInvoice>> result = invoiceRepository.getPendingInvoices();

            if (result.getResult() != null) {
                state.postValue(new State.PendingInvoiceList(result.getResult()));
            }
            else if (result.getError() != null) {
                state.postValue(new State.EmptyState());
            } else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.NoInternet());
            }
        }).start();
    }
}
