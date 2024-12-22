package com.example.gofuel.modelView.Invoiceline;

import android.util.Log;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoiceLine.InvoiceLineRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class InvoicelineViewModel extends ViewModel {
    private final InvoiceLineRepository invoiceLineRepository;
    private final MutableLiveData<State> state = new MutableLiveData<>();

    public InvoicelineViewModel() {
        invoiceLineRepository = InvoiceLineRepository.getInstance(MyApplication.getAppContext());
    }

    public MutableLiveData<State> getState() { return state; }

    public void loadLines(Invoice invoice) {
        state.setValue(new State.Loading());

        new Thread(() -> {
            ResultWrapper<List<InvoiceLine>> result = invoiceLineRepository.getInvoiceLines(invoice);

            if (result.getResult() != null) {
                double total = 0.0;
                for (InvoiceLine line : result.getResult()) {
                    total += line.getTotal();
                }
                state.postValue(new State.InvoiceLines(result.getResult(), total));
            }
            else if (result.getError() != null) {
                state.postValue(new State.EmptyState());
            }
            else {
                Log.e("-->", "Error API: " + result.getError());
                state.postValue(new State.NoInternet());
            }
        }).start();
    }
}
