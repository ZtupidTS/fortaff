Module SupplierPrima

    Sub getListSupplier(ByVal motor As ErpBS800.ErpBS)

        Dim supplier As GcpBE800.GcpBECliente
        'supplier = New GcpBE800.GcpBECliente()

        Dim listaclientes As StdBE800.StdBELista
        'testlist = motor.Consulta("select fornecedor from 

        'aqui obtenho toda a lista dos meus clientes existentes no primavera
        listaclientes = motor.Comercial.Clientes.LstClientes()

        Dim clientecod, erroatu As String
        erroatu = ""
        Dim i As Integer
        'aqui o meu ciclo para todos os clientes
        For i = 1 To listaclientes.NumLinhas

            clientecod = listaclientes.Valor(0)

            supplier = motor.Comercial.Clientes.Edita(clientecod)
            supplier.Pais = "PT"
            If motor.Comercial.Clientes.ValidaActualizacao(supplier, erroatu) Then
                motor.Comercial.Clientes.Actualiza(supplier)
            Else
                MsgBox("O cliente " & clientecod & " não foi atualizado")
                MsgBox("Código do erro: " & erroatu)
            End If
            listaclientes.Seguinte()
        Next

    End Sub

End Module
