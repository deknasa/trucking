var SimpleList = {
  "ReportVersion": "2023.1.1",
  "ReportGuid": "38ac46dc95327327be18751e1c81c830",
  "ReportName": "Report",
  "ReportAlias": "Report",
  "ReportFile": "http://localhost/trucking/public/reports/ReportLaporanKasBankBesarPusatSaldo.mrt",
  "ReportDescription": "14-10-2019",
  "ReportCreated": "/Date(0+0700)/",
  "ReportChanged": "/Date(1726728876000+0700)/",
  "EngineVersion": "EngineV2",
  "CalculationMode": "Interpretation",
  "ReportUnit": "Millimeters",
  "ScriptLanguage": "CSharp",
  "PreviewSettings": 268435455,
  "Styles": {
    "0": {
      "Ident": "StiTableStyle",
      "Name": "Style1",
      "BackColor": "255,255,255",
      "GridColor": "220,220,220"
    }
  },
  "Dictionary": {
    "DataSources": {
      "0": {
        "Ident": "StiDataTableSource",
        "Name": "root_data",
        "Alias": "root_data",
        "Columns": {
          "0": {
            "Name": "id",
            "NameInSource": "id",
            "Alias": "id",
            "Type": "System.String"
          },
          "1": {
            "Name": "urut",
            "NameInSource": "urut",
            "Alias": "urut",
            "Type": "System.String"
          },
          "2": {
            "Name": "urutdetail",
            "NameInSource": "urutdetail",
            "Alias": "urutdetail",
            "Type": "System.String"
          },
          "3": {
            "Name": "keterangancoa",
            "NameInSource": "keterangancoa",
            "Alias": "keterangancoa",
            "Type": "System.String"
          },
          "4": {
            "Name": "namabank",
            "NameInSource": "namabank",
            "Alias": "namabank",
            "Type": "System.String"
          },
          "5": {
            "Name": "tglbukti",
            "NameInSource": "tglbukti",
            "Alias": "tglbukti",
            "Type": "System.String"
          },
          "6": {
            "Name": "nobukti",
            "NameInSource": "nobukti",
            "Alias": "nobukti",
            "Type": "System.String"
          },
          "7": {
            "Name": "keterangan",
            "NameInSource": "keterangan",
            "Alias": "keterangan",
            "Type": "System.String"
          },
          "8": {
            "Name": "debet",
            "NameInSource": "debet",
            "Alias": "debet",
            "Type": "System.String"
          },
          "9": {
            "Name": "kredit",
            "NameInSource": "kredit",
            "Alias": "kredit",
            "Type": "System.String"
          },
          "10": {
            "Name": "totaldebet",
            "NameInSource": "totaldebet",
            "Alias": "totaldebet",
            "Type": "System.String"
          },
          "11": {
            "Name": "totalkredit",
            "NameInSource": "totalkredit",
            "Alias": "totalkredit",
            "Type": "System.String"
          },
          "12": {
            "Name": "saldo",
            "NameInSource": "saldo",
            "Alias": "saldo",
            "Type": "System.String"
          },
          "13": {
            "Name": "judulLaporan",
            "NameInSource": "judulLaporan",
            "Alias": "judulLaporan",
            "Type": "System.String"
          },
          "14": {
            "Name": "judul",
            "NameInSource": "judul",
            "Alias": "judul",
            "Type": "System.String"
          },
          "15": {
            "Name": "tglcetak",
            "NameInSource": "tglcetak",
            "Alias": "tglcetak",
            "Type": "System.String"
          },
          "16": {
            "Name": "usercetak",
            "NameInSource": "usercetak",
            "Alias": "usercetak",
            "Type": "System.String"
          },
          "17": {
            "Name": "relationId",
            "NameInSource": "relationId",
            "Alias": "relationId",
            "Type": "System.String"
          },
          "18": {
            "Name": "tglbukti2",
            "NameInSource": "tglbukti2",
            "Alias": "tglbukti2",
            "Type": "System.String"
          }
        },
        "NameInSource": "Data.root_data"
      },
      "1": {
        "Ident": "StiDataTableSource",
        "Name": "root_datasaldo",
        "Alias": "root_datasaldo",
        "Columns": {
          "0": {
            "Name": "urut",
            "NameInSource": "urut",
            "Alias": "urut",
            "Type": "System.String"
          },
          "1": {
            "Name": "urutdetail",
            "NameInSource": "urutdetail",
            "Alias": "urutdetail",
            "Type": "System.String"
          },
          "2": {
            "Name": "coa",
            "NameInSource": "coa",
            "Alias": "coa",
            "Type": "System.String"
          },
          "3": {
            "Name": "tglbukti",
            "NameInSource": "tglbukti",
            "Alias": "tglbukti",
            "Type": "System.DateTime"
          },
          "4": {
            "Name": "nobukti",
            "NameInSource": "nobukti",
            "Alias": "nobukti",
            "Type": "System.String"
          },
          "5": {
            "Name": "keterangan",
            "NameInSource": "keterangan",
            "Alias": "keterangan",
            "Type": "System.String"
          },
          "6": {
            "Name": "debet",
            "NameInSource": "debet",
            "Alias": "debet",
            "Type": "System.String"
          },
          "7": {
            "Name": "kredit",
            "NameInSource": "kredit",
            "Alias": "kredit",
            "Type": "System.String"
          },
          "8": {
            "Name": "saldo",
            "NameInSource": "saldo",
            "Alias": "saldo",
            "Type": "System.Decimal"
          },
          "9": {
            "Name": "relationId",
            "NameInSource": "relationId",
            "Alias": "relationId",
            "Type": "System.String"
          }
        },
        "NameInSource": "Data.root_datasaldo"
      },
      "2": {
        "Ident": "StiDataTableSource",
        "Name": "root_infopemeriksa",
        "Alias": "root_infopemeriksa",
        "Columns": {
          "0": {
            "Name": "dibuat",
            "NameInSource": "dibuat",
            "Alias": "dibuat",
            "Type": "System.String"
          },
          "1": {
            "Name": "diperiksa",
            "NameInSource": "diperiksa",
            "Alias": "diperiksa",
            "Type": "System.String"
          },
          "2": {
            "Name": "disetujui",
            "NameInSource": "disetujui",
            "Alias": "disetujui",
            "Type": "System.String"
          },
          "3": {
            "Name": "relationId",
            "NameInSource": "relationId",
            "Alias": "relationId",
            "Type": "System.String"
          }
        },
        "NameInSource": "Data.root_infopemeriksa"
      },
      "3": {
        "Ident": "StiDataTableSource",
        "Name": "root_parameter",
        "Alias": "root_parameter",
        "Columns": {
          "0": {
            "Name": "dari",
            "NameInSource": "dari",
            "Alias": "dari",
            "Type": "System.String"
          },
          "1": {
            "Name": "sampai",
            "NameInSource": "sampai",
            "Alias": "sampai",
            "Type": "System.String"
          },
          "2": {
            "Name": "bank_id",
            "NameInSource": "bank_id",
            "Alias": "bank_id",
            "Type": "System.String"
          },
          "3": {
            "Name": "bank",
            "NameInSource": "bank",
            "Alias": "bank",
            "Type": "System.String"
          },
          "4": {
            "Name": "periodedata_id",
            "NameInSource": "periodedata_id",
            "Alias": "periodedata_id",
            "Type": "System.String"
          },
          "5": {
            "Name": "periodedata",
            "NameInSource": "periodedata",
            "Alias": "periodedata",
            "Type": "System.String"
          },
          "6": {
            "Name": "relationId",
            "NameInSource": "relationId",
            "Alias": "relationId",
            "Type": "System.String"
          }
        },
        "NameInSource": "Data.root_parameter"
      },
      "4": {
        "Ident": "StiDataTableSource",
        "Name": "root",
        "Alias": "root",
        "Columns": {
          "0": {
            "Name": "data",
            "NameInSource": "data",
            "Alias": "data",
            "Type": "System.String"
          },
          "1": {
            "Name": "datasaldo",
            "NameInSource": "datasaldo",
            "Alias": "datasaldo",
            "Type": "System.String"
          },
          "2": {
            "Name": "infopemeriksa",
            "NameInSource": "infopemeriksa",
            "Alias": "infopemeriksa",
            "Type": "System.String"
          },
          "3": {
            "Name": "dataCabang",
            "NameInSource": "dataCabang",
            "Alias": "dataCabang",
            "Type": "System.String"
          },
          "4": {
            "Name": "parameter",
            "NameInSource": "parameter",
            "Alias": "parameter",
            "Type": "System.String"
          }
        },
        "NameInSource": "Data.root"
      },
      "5": {
        "Ident": "StiDataTableSource",
        "Name": "root2",
        "Alias": "root2",
        "Columns": {
          "0": {
            "Name": "body",
            "NameInSource": "body",
            "Alias": "body",
            "Type": "System.String"
          },
          "1": {
            "Name": "email",
            "NameInSource": "email",
            "Alias": "email",
            "Type": "System.String"
          },
          "2": {
            "Name": "id",
            "NameInSource": "id",
            "Alias": "id",
            "Type": "System.Decimal"
          },
          "3": {
            "Name": "name",
            "NameInSource": "name",
            "Alias": "name",
            "Type": "System.String"
          },
          "4": {
            "Name": "postId",
            "NameInSource": "postId",
            "Alias": "postId",
            "Type": "System.Decimal"
          }
        },
        "NameInSource": "comments.root"
      }
    },
    "Databases": {
      "0": {
        "Ident": "StiJsonDatabase",
        "Name": "comments",
        "Alias": "comments",
        "PathData": "https://jsonplaceholder.typicode.com/comments"
      }
    },
    "Relations": {
      "0": {
        "Name": "root",
        "ChildColumns": {
          "0": "relationId"
        },
        "ParentColumns": {
          "0": "data"
        },
        "NameInSource": "root_data",
        "Alias": "root",
        "ParentSource": "root",
        "ChildSource": "root_data"
      },
      "1": {
        "Name": "root",
        "ChildColumns": {
          "0": "relationId"
        },
        "ParentColumns": {
          "0": "datasaldo"
        },
        "NameInSource": "root_datasaldo",
        "Alias": "root",
        "ParentSource": "root",
        "ChildSource": "root_datasaldo"
      },
      "2": {
        "Name": "root",
        "ChildColumns": {
          "0": "relationId"
        },
        "ParentColumns": {
          "0": "infopemeriksa"
        },
        "NameInSource": "root_infopemeriksa",
        "Alias": "root",
        "ParentSource": "root",
        "ChildSource": "root_infopemeriksa"
      },
      "3": {
        "Name": "root",
        "ChildColumns": {
          "0": "relationId"
        },
        "ParentColumns": {
          "0": "parameter"
        },
        "NameInSource": "root_parameter",
        "Alias": "root",
        "ParentSource": "root",
        "ChildSource": "root_parameter"
      }
    }
  },
  "Pages": {
    "0": {
      "Ident": "StiPage",
      "Name": "Page1",
      "Guid": "49c519741dad4a89981d644d00fedc94",
      "Interaction": {
        "Ident": "StiInteraction"
      },
      "Border": ";;2;;;;;solid:Black",
      "Brush": "solid:",
      "Components": {
        "0": {
          "Ident": "StiPageHeaderBand",
          "Name": "PageHeaderBand1",
          "ClientRectangle": "0,4,289.9,23.8",
          "ComponentPlacement": "ph.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Components": {
            "0": {
              "Ident": "StiText",
              "Name": "Text34",
              "Guid": "347760637548aec35ff6663261f9fd28",
              "ClientRectangle": "153,20,48,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "TRUCKING"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "1": {
              "Ident": "StiText",
              "Name": "Text2",
              "Guid": "4047f57b40e682eb45aa228bdf7d1738",
              "ClientRectangle": "2.1,0.06,268.06,9.38",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "PT. TRANSPORINDO AGUNG SEJAHTERA"
              },
              "Font": "Tahoma;10;Bold;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "2": {
              "Ident": "StiText",
              "Name": "Text1",
              "Guid": "53b04f58c5012fd15eff2effc6cb4df6",
              "ClientRectangle": "226,0.1,59.16,3.81",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.tglcetak}"
              },
              "HorAlignment": "Right",
              "VertAlignment": "Center",
              "Font": "Tahoma;;Italic;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:0,0,0",
              "Type": "Expression"
            },
            "3": {
              "Ident": "StiText",
              "Name": "Text79",
              "Guid": "e62e51bb46b00aae7b95f6633229ede2",
              "ClientRectangle": "231.08,4,54.04,4.06",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.usercetak}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;;Italic;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "4": {
              "Ident": "StiText",
              "Name": "Text4",
              "Guid": "f3468d3acec22c9cc1a4e4ffaa6842d9",
              "ClientRectangle": "2.03,11,14,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Periode"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "5": {
              "Ident": "StiText",
              "Name": "Text5",
              "Guid": "40b96146bfc7f4c5b3bdd95e58a0535d",
              "ClientRectangle": "14,11,4,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": ":"
              },
              "Font": "Tahoma;7;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "6": {
              "Ident": "StiText",
              "Name": "Text6",
              "Guid": "a910357d94316417f48172f8499c56ea",
              "ClientRectangle": "16.08,11,22,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "20-04-2023"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "7": {
              "Ident": "StiText",
              "Name": "Text7",
              "Guid": "0ecc49e3a25b03f41d7b91e7b337b00e",
              "ClientRectangle": "39.97,11,32,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "20-04-2023"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "8": {
              "Ident": "StiText",
              "Name": "Text8",
              "Guid": "1edb1c4cfdfddba60d8f67169d983d60",
              "ClientRectangle": "33.96,11,8,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "s/d"
              },
              "Font": "Comic Sans MS3;;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "9": {
              "Ident": "StiText",
              "Name": "Text9",
              "Guid": "f47cef1884666d89d616bd67de20014a",
              "ClientRectangle": "20,16,34,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "NO BUKTI"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "10": {
              "Ident": "StiText",
              "Name": "Text10",
              "Guid": "f98926edd5e45053f1e42a44f08d4776",
              "ClientRectangle": "55,16,34,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "NAMA PERKIRAAN"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "11": {
              "Ident": "StiText",
              "Name": "Text11",
              "Guid": "a1ecbfa9c66dafd3b6bd4f683e18ce17",
              "ClientRectangle": "90,16,62,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "KETERANGAN"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "12": {
              "Ident": "StiText",
              "Name": "Text12",
              "Guid": "8fcac4d10275a235cd130a937deb1577",
              "ClientRectangle": "202,16,26,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "DEBET"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "13": {
              "Ident": "StiText",
              "Name": "Text13",
              "Guid": "f1771edf7ff2e83f8a6984fe1b9571af",
              "ClientRectangle": "228,16,26,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "KREDIT"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "14": {
              "Ident": "StiText",
              "Name": "Text14",
              "Guid": "c6c3473eb782b8fc51a94a7d87728a06",
              "ClientRectangle": "254,16,30,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "SALDO"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "15": {
              "Ident": "StiText",
              "Name": "Text31",
              "Guid": "92b22c2a4a625cb48288fee932303524",
              "ClientRectangle": "2,16,18,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "TANGGAL"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "16": {
              "Ident": "StiText",
              "Name": "Text33",
              "Guid": "cf95e1b2fced64763a410fb3716ec15e",
              "ClientRectangle": "2,4,268,6",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Laporan Kas Bank"
              },
              "Font": "Tahoma;10;Bold;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "17": {
              "Ident": "StiText",
              "Name": "Text35",
              "Guid": "e312d3303ff54a336607417fda476f62",
              "ClientRectangle": "153,16,24,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "DEBET"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "18": {
              "Ident": "StiText",
              "Name": "Text36",
              "Guid": "4e4f9fc59c23641538dc237d5fa645e1",
              "ClientRectangle": "177,16,24.5,4",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "KREDIT"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": "All;;;None;;;;solid:0,0,0",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "19": {
              "Ident": "StiShape",
              "Name": "Shape1",
              "ClientRectangle": "2,22,0,8",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Brush": "solid:",
              "ShapeType": {
                "Ident": "StiVerticalLineShapeType"
              },
              "Font": "Tahoma;9;Bold;"
            },
            "20": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive6",
              "Guid": "f51782f205948a6c8ae18113598fb651",
              "ClientRectangle": "2.03,16,283,0.254",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "21": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive6",
              "ClientRectangle": "2,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "8471052fdb7a43a12b725bf5bbbc847d"
            },
            "22": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive7",
              "ClientRectangle": "20,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "9bec4f6b99eca3b449c105b646ec27c0"
            },
            "23": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive7",
              "ClientRectangle": "20,23.71,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "9bec4f6b99eca3b449c105b646ec27c0"
            },
            "24": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive8",
              "ClientRectangle": "54.59,16.09,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "0dcb02c13424c9292a10a87a4378ad1c"
            },
            "25": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive9",
              "ClientRectangle": "90,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "bea3b68f32f28cde7aa44dcffe300f0e"
            },
            "26": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive9",
              "ClientRectangle": "90,23.71,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "bea3b68f32f28cde7aa44dcffe300f0e"
            },
            "27": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive10",
              "ClientRectangle": "153,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "dcba975fd3df14dc79f34f58272bce3c"
            },
            "28": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive10",
              "ClientRectangle": "153,23.71,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "dcba975fd3df14dc79f34f58272bce3c"
            },
            "29": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive11",
              "ClientRectangle": "228,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "d83b7d5029b549413bd639147f2b1f3d"
            },
            "30": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive11",
              "ClientRectangle": "228,23.71,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "d83b7d5029b549413bd639147f2b1f3d"
            },
            "31": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive12",
              "ClientRectangle": "254,16.09,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "e147d2eca0cbf02892b44aa0e0b595f4"
            },
            "32": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive13",
              "ClientRectangle": "285,15.89,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "52da9f1b1189fbf0de7de2294e2987cb"
            },
            "33": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive14",
              "ClientRectangle": "202,16,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "a25aeae03ef9293954d3af6d5ed457c6"
            },
            "34": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive14",
              "ClientRectangle": "202,23.82,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "a25aeae03ef9293954d3af6d5ed457c6"
            },
            "35": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive15",
              "ClientRectangle": "177,16,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "e9217b9496a78ef0bbc12fb98537fc9b"
            },
            "36": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive15",
              "ClientRectangle": "177,19.82,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "e9217b9496a78ef0bbc12fb98537fc9b"
            },
            "37": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive5",
              "Guid": "04d507c1ea146d343196669dc4513b0a",
              "ClientRectangle": "153,20,49,0.254",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "38": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive9",
              "Guid": "2717b46a17e6deb7ba10dc5746c36a93",
              "ClientRectangle": "2.03,23.85,283,0.254",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "39": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive8",
              "ClientRectangle": "54.59,23.91,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "0dcb02c13424c9292a10a87a4378ad1c"
            },
            "40": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive12",
              "ClientRectangle": "254,23.91,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "e147d2eca0cbf02892b44aa0e0b595f4"
            },
            "41": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive6",
              "ClientRectangle": "2,23.99,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "8471052fdb7a43a12b725bf5bbbc847d"
            },
            "42": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive13",
              "ClientRectangle": "285,23.99,0,0",
              "ComponentPlacement": "ph.PageHeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "52da9f1b1189fbf0de7de2294e2987cb"
            }
          }
        },
        "1": {
          "Ident": "StiPageFooterBand",
          "Name": "PageFooterBand1",
          "ClientRectangle": "0,189.1,289.9,10",
          "ComponentPlacement": "pf.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Components": {
            "0": {
              "Ident": "StiText",
              "Name": "Text51",
              "Guid": "b08203d130f581cc3d25dfb871e1efe6",
              "ClientRectangle": "227.01,-0.19,58.68,4.06",
              "ComponentPlacement": "pf.PageFooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Hal:{PageNumber} dari {TotalPageCount}"
              },
              "HorAlignment": "Right",
              "Font": "SourceSansPro;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            }
          }
        },
        "2": {
          "Ident": "StiHeaderBand",
          "Name": "HeaderBand1",
          "PrintOn": "OnlyFirstPage",
          "ClientRectangle": "0,35.8,289.9,8",
          "ComponentPlacement": "h.ap.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Components": {
            "0": {
              "Ident": "StiText",
              "Name": "Text15",
              "Guid": "8ad2714ecf6d94067c3a08a55a83eb45",
              "PrintOn": "OnlyFirstPage",
              "ClientRectangle": "4.06,-0.12,30,6",
              "ComponentPlacement": "h.ap.HeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Buku Kas / Bank"
              },
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "1": {
              "Ident": "StiText",
              "Name": "Text16",
              "Guid": "046f7a0c0e0a2fc61815274839d67327",
              "PrintOn": "OnlyFirstPage",
              "ClientRectangle": "34.04,-0.12,4,6",
              "ComponentPlacement": "h.ap.HeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": ":"
              },
              "VertAlignment": "Center",
              "Font": "Tahoma;;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "2": {
              "Ident": "StiText",
              "Name": "Text17",
              "Guid": "dbec7627b452a50527b9e320ab3b6764",
              "PrintOn": "OnlyFirstPage",
              "ClientRectangle": "38.1,-0.12,30,6",
              "ComponentPlacement": "h.ap.HeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.namabank}"
              },
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "3": {
              "Ident": "StiText",
              "Name": "Text28",
              "Guid": "7af0a9a65694769698dc63b6eaccd961",
              "PrintOn": "OnlyFirstPage",
              "ClientRectangle": "88,4,30,4",
              "ComponentPlacement": "h.ap.HeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "SALDO AWAL"
              },
              "Font": "Tahoma;9;Bold;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "4": {
              "Ident": "StiText",
              "Name": "Text39",
              "Guid": "b27ae7cbf781781ad0945c96b74ce22a",
              "PrintOn": "OnlyFirstPage",
              "CanGrow": true,
              "ClientRectangle": "257,4,27,4",
              "ComponentPlacement": "h.ap.HeaderBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_datasaldo.saldo}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            }
          }
        },
        "3": {
          "Ident": "StiGroupHeaderBand",
          "Name": "GroupHeaderBand1",
          "ClientRectangle": "0,51.8,289.9,0",
          "ComponentPlacement": "gh.Page1",
          "Interaction": {
            "Ident": "StiBandInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Condition": {
            "Value": "{root_data.urut}"
          }
        },
        "4": {
          "Ident": "StiGroupHeaderBand",
          "Name": "GroupHeaderBand2",
          "ClientRectangle": "0,59.8,289.9,0",
          "ComponentPlacement": "gh.Page1",
          "Interaction": {
            "Ident": "StiBandInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Condition": {
            "Value": "{root_data.tglbukti}"
          }
        },
        "5": {
          "Ident": "StiGroupHeaderBand",
          "Name": "GroupHeaderBand3",
          "ClientRectangle": "0,67.8,289.9,1",
          "ComponentPlacement": "gh.Page1",
          "Interaction": {
            "Ident": "StiBandInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Condition": {
            "Value": "{root_data.nobukti}"
          }
        },
        "6": {
          "Ident": "StiDataBand",
          "Name": "DataBand1",
          "ClientRectangle": "0,76.8,289.9,1",
          "ComponentPlacement": "d.Page1",
          "Interaction": {
            "Ident": "StiBandInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Components": {
            "0": {
              "Ident": "StiText",
              "Name": "Text27",
              "Guid": "d58d2714a378f7fa0793a745b2ba9db2",
              "CanGrow": true,
              "ClientRectangle": "257,0,27,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.saldo}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "1": {
              "Ident": "StiText",
              "Name": "Text20",
              "Guid": "53b11f16965b8f1091ec0cbc0ec1b8cf",
              "CanGrow": true,
              "ClientRectangle": "178.5,0,23,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.kredit}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "2": {
              "Ident": "StiText",
              "Name": "Text25",
              "Guid": "f015f5c0bd925230caac8d15c9294fc1",
              "CanGrow": true,
              "ClientRectangle": "202.5,0,25,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "root_data.totaldebet",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.totaldebet}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "3": {
              "Ident": "StiText",
              "Name": "Text38",
              "Guid": "34b3ba5948f9a7bb816cafd638deefdf",
              "CanGrow": true,
              "ClientRectangle": "228.5,0,25,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "root_data.totalkredit",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.totalkredit}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "DataColumn"
            },
            "4": {
              "Ident": "StiText",
              "Name": "Text23",
              "Guid": "a91f497eb014c8dfc40781c6188f9f19",
              "CanGrow": true,
              "ClientRectangle": "153.5,0,23,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.debet}"
              },
              "HorAlignment": "Right",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "5": {
              "Ident": "StiText",
              "Name": "Text22",
              "Guid": "2b643fa7e677a9a771103263ed36bfae",
              "CanGrow": true,
              "ClientRectangle": "91,0,61,6",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root2.email}"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "Type": "DataColumn"
            },
            "6": {
              "Ident": "StiText",
              "Name": "Text21",
              "Guid": "91a448fde875072e545ba98196f18e97",
              "CanGrow": true,
              "ClientRectangle": "55.28,0.06,34,6.09",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root2.body}"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "Type": "DataColumn"
            },
            "7": {
              "Ident": "StiText",
              "Name": "Text37",
              "Guid": "93a79f5e0770a58adb08872bee793fda",
              "CanGrow": true,
              "ClientRectangle": "21.05,0.07,32.45,5.9",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root2.name}"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "Type": "DataColumn"
            },
            "8": {
              "Ident": "StiText",
              "Name": "Text32",
              "Guid": "da2f25dfcfb46d3b4d765e109f348641",
              "CanGrow": true,
              "ClientRectangle": "2.54,0.06,16.99,6.09",
              "ComponentPlacement": "d.DataBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Condition": "NotEqualTo",
                  "Column": "data.urutdetail",
                  "Value1": "1.0",
                  "Enabled": false,
                  "BorderSides": "None"
                },
                "1": {
                  "Ident": "StiCondition",
                  "Column": "data.nobukti",
                  "Value1": "SALDO AWAL",
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.tglbukti}"
              },
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiDateFormatService",
                "StringFormat": "dd/MM/yyyy"
              },
              "Type": "Expression"
            }
          },
          "DataSourceName": "root2",
          "Sort": {
            "0": "ASC",
            "1": "FNInvoice",
            "2": "ASC",
            "3": "FUrut"
          }
        },
        "7": {
          "Ident": "StiFooterBand",
          "Name": "FooterBand1",
          "ClientRectangle": "0,85.8,289.9,32",
          "ComponentPlacement": "f.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "Border": ";;;;;;;solid:Black",
          "Brush": "solid:",
          "Components": {
            "0": {
              "Ident": "StiText",
              "Name": "Text24",
              "Guid": "cb0f6f9f84d170271ec790e71e997944",
              "ClientRectangle": "202,0,25,6.06",
              "ComponentPlacement": "f.FooterBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "DataType": "Numeric",
                  "Item": "Expression",
                  "Expression": {
                    "Value": "{Sum(data.debet) == 0}"
                  },
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{Sum(root_data.debet)}"
              },
              "HorAlignment": "Right",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "1": {
              "Ident": "StiText",
              "Name": "Text26",
              "Guid": "731e7bb600ab69d7f68b1f523defcf78",
              "ClientRectangle": "228.5,0,25,6",
              "ComponentPlacement": "f.FooterBand1",
              "Conditions": {
                "0": {
                  "Ident": "StiCondition",
                  "Item": "Expression",
                  "Expression": {
                    "Value": "{Sum(data.kredit) == 0}"
                  },
                  "Enabled": false,
                  "BorderSides": "None"
                }
              },
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{Sum(root_data.kredit)}"
              },
              "HorAlignment": "Right",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "2": {
              "Ident": "StiText",
              "Name": "Text3",
              "Guid": "df96c81effd6fe84684bc655d7537bc3",
              "CanGrow": true,
              "ClientRectangle": "257,0,27,6",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_data.saldo}"
              },
              "HorAlignment": "Right",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "TextFormat": {
                "Ident": "StiNumberFormatService",
                "NegativePattern": 1,
                "GroupSeparator": ","
              },
              "Type": "Expression"
            },
            "3": {
              "Ident": "StiText",
              "Name": "Text18",
              "Guid": "d970d0f5ff49e3d4d9d10a92270cac73",
              "ClientRectangle": "70,8,34,8",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Disetujui"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "4": {
              "Ident": "StiText",
              "Name": "Text29",
              "Guid": "0dd0ad544ec647211a07bcbe4b328754",
              "ClientRectangle": "2,8,34,8",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Dibuat"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "5": {
              "Ident": "StiText",
              "Name": "Text30",
              "Guid": "4442701fe82b9e42c9c97bfab8442dff",
              "ClientRectangle": "36,8,34,8",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Diperiksa"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "6": {
              "Ident": "StiText",
              "Name": "Text19",
              "Guid": "122550f2c98d0c57ed7e36d0a18e34c3",
              "ClientRectangle": "6,0,30,6",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "Total"
              },
              "VertAlignment": "Center",
              "Font": "Tahoma;9;Bold;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "TextOptions": {
                "WordWrap": true
              },
              "Type": "Expression"
            },
            "7": {
              "Ident": "StiText",
              "Name": "Text42",
              "Guid": "9aa3a949d9c819dfe4de01d17641d788",
              "ClientRectangle": "70,28,34,4",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_infopemeriksa.disetujui}"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "8": {
              "Ident": "StiText",
              "Name": "Text41",
              "Guid": "5fba2d4492b53756a8acbe4f57c8086c",
              "ClientRectangle": "36,28,34,4",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_infopemeriksa.diperiksa}"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "9": {
              "Ident": "StiText",
              "Name": "Text40",
              "Guid": "f225ee4aa730fbcbd53e4196084e3266",
              "ClientRectangle": "2,28,34,4",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "Text": {
                "Value": "{root_infopemeriksa.dibuat}"
              },
              "HorAlignment": "Center",
              "VertAlignment": "Center",
              "Font": "Tahoma;9;;",
              "Border": ";;;;;;;solid:Black",
              "Brush": "solid:",
              "TextBrush": "solid:Black",
              "Type": "Expression"
            },
            "10": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive1",
              "ClientRectangle": "1.93,8,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "28ff3d487368a24347be456d8145e04b"
            },
            "11": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive3",
              "ClientRectangle": "103.95,8,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "f487e1280fc17face20c3b6491ae2ed4"
            },
            "12": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive4",
              "ClientRectangle": "70.08,8,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "10b5f25bb8f75c4770ab361086957515"
            },
            "13": {
              "Ident": "StiStartPointPrimitive",
              "Name": "StartPointPrimitive5",
              "ClientRectangle": "36,8,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "271db0b4beb787be03a58bb4b0f74b11"
            },
            "14": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive3",
              "Guid": "2001a98d88e3c71d5169c09d46f7673f",
              "ClientRectangle": "2.15,5.92,283,0.254",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "15": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive8",
              "Guid": "30c704330d5a65cbca9027c8eac677a8",
              "ClientRectangle": "2,16,102,0.254",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "16": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive10",
              "Guid": "942db3cdbd913b39dfd5a7794343e625",
              "ClientRectangle": "1.71,7.97,102,0.254",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "17": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive2",
              "Guid": "7bb6309d88bc5b7685f5d7eb543f6339",
              "ClientRectangle": "2.15,0.11,283,0.254",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            },
            "18": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive3",
              "ClientRectangle": "103.95,31.92,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "f487e1280fc17face20c3b6491ae2ed4"
            },
            "19": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive4",
              "ClientRectangle": "70.08,31.92,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "10b5f25bb8f75c4770ab361086957515"
            },
            "20": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive5",
              "ClientRectangle": "36,31.92,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "271db0b4beb787be03a58bb4b0f74b11"
            },
            "21": {
              "Ident": "StiEndPointPrimitive",
              "Name": "EndPointPrimitive1",
              "ClientRectangle": "1.93,31.92,0,0",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "ReferenceToGuid": "28ff3d487368a24347be456d8145e04b"
            },
            "22": {
              "Ident": "StiHorizontalLinePrimitive",
              "Name": "HorizontalLinePrimitive4",
              "Guid": "7d51d95faed4b39ccf2b7a8316cddf78",
              "ClientRectangle": "2,32,102,0.254",
              "ComponentPlacement": "f.FooterBand1",
              "Interaction": {
                "Ident": "StiInteraction"
              },
              "StartCap": ";;;",
              "EndCap": ";;;"
            }
          }
        },
        "8": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive1",
          "Guid": "28ff3d487368a24347be456d8145e04b",
          "ClientRectangle": "1.93,93.8,0.254,23.92",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "9": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive4",
          "Guid": "f487e1280fc17face20c3b6491ae2ed4",
          "ClientRectangle": "103.95,93.8,0.254,23.92",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "10": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive17",
          "Guid": "10b5f25bb8f75c4770ab361086957515",
          "ClientRectangle": "70.08,93.8,0.254,23.92",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "11": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive18",
          "Guid": "271db0b4beb787be03a58bb4b0f74b11",
          "ClientRectangle": "36,93.8,0.254,23.92",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "12": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive3",
          "Guid": "8471052fdb7a43a12b725bf5bbbc847d",
          "ClientRectangle": "2,19.89,0.254,8.1",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "13": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive5",
          "Guid": "9bec4f6b99eca3b449c105b646ec27c0",
          "ClientRectangle": "20,19.89,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "14": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive6",
          "Guid": "0dcb02c13424c9292a10a87a4378ad1c",
          "ClientRectangle": "54.59,20.09,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "15": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive7",
          "Guid": "bea3b68f32f28cde7aa44dcffe300f0e",
          "ClientRectangle": "90,19.89,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "16": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive8",
          "Guid": "dcba975fd3df14dc79f34f58272bce3c",
          "ClientRectangle": "153,19.89,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "17": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive9",
          "Guid": "d83b7d5029b549413bd639147f2b1f3d",
          "ClientRectangle": "228,19.89,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "18": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive10",
          "Guid": "e147d2eca0cbf02892b44aa0e0b595f4",
          "ClientRectangle": "254,20.09,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "19": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive11",
          "Guid": "52da9f1b1189fbf0de7de2294e2987cb",
          "ClientRectangle": "285,19.89,0.254,8.1",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "20": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive12",
          "Guid": "a25aeae03ef9293954d3af6d5ed457c6",
          "ClientRectangle": "202,20,0.254,7.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        },
        "21": {
          "Ident": "StiVerticalLinePrimitive",
          "Name": "VerticalLinePrimitive13",
          "Guid": "e9217b9496a78ef0bbc12fb98537fc9b",
          "ClientRectangle": "177,20,0.254,3.82",
          "ComponentPlacement": "p.Page1",
          "Interaction": {
            "Ident": "StiInteraction"
          },
          "StartCap": ";;;",
          "EndCap": ";;;"
        }
      },
      "PaperSize": "A4",
      "Orientation": "Landscape",
      "PageWidth": 296.9,
      "PageHeight": 210.1,
      "Watermark": {
        "TextBrush": "solid:50,0,0,0"
      },
      "Margins": {
        "Left": 4,
        "Right": 3,
        "Top": 10,
        "Bottom": 1
      }
    }
  }
}