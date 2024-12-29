package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.gofuel.databinding.FragmentCartBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.modelView.Invoiceline.InvoicelineAdapter;
import com.example.gofuel.modelView.Invoiceline.InvoicelineViewModel;
import com.example.gofuel.util.State;
import com.example.gofuel.util.callback.OnCheckedBox;

import java.text.DecimalFormat;
import java.util.ArrayList;

public class CartFragment extends Fragment {
    private FragmentCartBinding binding;
    private Invoice invoice;
    private InvoicelineViewModel viewModel;
    private ArrayList<InvoiceLine> linesToChange;

    public CartFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCartBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(InvoicelineViewModel.class);
        linesToChange = new ArrayList<>();

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
                Double total = lines
                        .stream()
                        .mapToDouble(InvoiceLine::getTotal)
                        .sum();
                binding.linesList.setAdapter(new InvoicelineAdapter(getContext(), lines, new OnCheckedBox() {
                    @Override
                    public void onChecked(InvoiceLine line) {
                        linesToChange.add(line);
                    }

                    @Override
                    public void onUnchecked(InvoiceLine line) {
                        linesToChange.remove(line);
                    }
                }));
                binding.totalValue.setText(String.format("%.2f", total) + "€");
            }
        });

        binding.removeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                viewModel.removeLines(linesToChange);
                Toast.makeText(getContext(), linesToChange.size() + " lines removed", Toast.LENGTH_SHORT).show();
            }
        });

        viewModel.loadLines(invoice);

        return view;
    }

    public void setInvoice(Invoice invoice) {
        this.invoice = invoice;
    }
}