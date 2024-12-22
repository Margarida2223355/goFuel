package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.databinding.FragmentCartBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.modelView.Invoiceline.InvoicelineAdapter;
import com.example.gofuel.modelView.Invoiceline.InvoicelineViewModel;
import com.example.gofuel.util.State;

import java.util.ArrayList;

public class CartFragment extends Fragment {
    private FragmentCartBinding binding;
    private Invoice invoice;
    private InvoicelineViewModel viewModel;

    public CartFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCartBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(InvoicelineViewModel.class);

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.linesList.setVisibility(View.GONE);
                binding.totalCard.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }
            else if (state instanceof State.InvoiceLines) {
                binding.loading.setVisibility(View.GONE);
                binding.linesList.setVisibility(View.VISIBLE);
                binding.totalCard.setVisibility(View.VISIBLE);
                ArrayList<InvoiceLine> lines = new ArrayList<>(((State.InvoiceLines) state).getInvoiceLines());
                binding.linesList.setAdapter(new InvoicelineAdapter(getContext(), lines));
            }
        });

        viewModel.loadLines(invoice);

        return view;
    }

    public void setInvoice(Invoice invoice) {
        this.invoice = invoice;
    }
}