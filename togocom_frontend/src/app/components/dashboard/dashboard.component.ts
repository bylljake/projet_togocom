import { Component, Input, OnInit } from "@angular/core";
import { NgbCalendar, NgbDateStruct } from "@ng-bootstrap/ng-bootstrap";

@Component({
  selector: "app-dashboard",
  templateUrl: "./dashboard.component.html",
  styleUrls: ["./dashboard.component.scss"],
})
export class DashboardComponent implements OnInit {
  
  @Input() data: any
  constructor(calendar: NgbCalendar) {}

  ngOnInit() {}
  
}
